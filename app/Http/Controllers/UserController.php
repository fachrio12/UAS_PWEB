<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\UserAssessmentSession;
use App\Models\UserAnswer;
use App\Models\AssessmentResult;
use App\Models\MotivationFactor;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function submitAssessment(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:options,id',
        ]);

        $session = UserAssessmentSession::create([
            'user_id' => Auth::id(),
            'assessment_id' => $assessment->id,
        ]);
        
        foreach ($validated['answers'] as $questionId => $optionId) {
            UserAnswer::create([
                'session_id' => $session->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);
        }

        $this->calculateResults($session);
        
        return redirect()->route('user.results', $session->id)
            ->with('success', 'Asesmen berhasil diselesaikan!');
    }
    
    private function calculateResults(UserAssessmentSession $session)
    {
        $answers = $session->answers()->with('option')->get();   
        $categories = [];
        $totalScore = 0;
        
        foreach ($answers as $answer) {
            $totalScore += $answer->option->score;
        }

        AssessmentResult::create([
            'session_id' => $session->id,
            'result_category' => 'Overall Score',
            'score' => $totalScore,
            'interpretation' => $this->getInterpretation($totalScore, $session->assessment->name),
        ]);        
        
        MotivationFactor::create([
            'session_id' => $session->id,
            'factor_name' => 'Engagement',
            'score' => min(100, $totalScore * 5), 
        ]);
    }
    
    private function getInterpretation($score, $assessmentName)
{
    // Normalisasi nama untuk memudahkan pencocokan
    $type = strtolower($assessmentName);

    if ($type === 'minat bakat') {
        if ($score < 50) {
            return 'Hasil menunjukkan kamu cenderung memiliki potensi di bidang non-akademik seperti seni, olahraga, atau keterampilan vokasional. Pertimbangkan mengembangkan bakatmu di area tersebut 🌟';
        } else {
            return 'Kamu memiliki kecenderungan kuat di bidang akademik. Cobalah mengeksplorasi bidang seperti sains, matematika, atau literasi ✨';
        }
    }

    elseif ($type === 'kecenderungan otak (kanan/kiri)') {
        if ($score <= 50) {
            return 'Kamu cenderung dominan otak kanan. Ini berarti kamu mungkin lebih kreatif, intuitif, imajinatif, dan ekspresif. Cocok di bidang seni, desain, atau ide-ide orisinal 🎨';
        } else {
            return 'Kamu cenderung dominan otak kiri. Kamu lebih logis, sistematis, dan analitis. Cocok di bidang sains, teknologi, matematika, dan strategi 📘';
        }
    }

    elseif ($type === 'motivasi belajar') {
        if ($score < 50) {
            return 'Motivasi belajar kamu saat ini masih perlu ditingkatkan. Cobalah membuat tujuan belajar yang jelas dan menemukan cara belajar yang menyenangkan 💪📚';
        } else {
            return 'Motivasi belajar kamu sudah berada di tingkat baik. Pertahankan semangatmu dan terus belajar dengan konsisten! 🚀';
        }
    }

    elseif ($type === 'gaya belajar') {
        if ($score >= 1 && $score <= 30) {
            return 'Gaya belajar kamu adalah *Auditori*. Kamu belajar lebih baik dengan mendengarkan, seperti melalui diskusi, rekaman, atau penjelasan verbal 🎧';
        } elseif ($score >= 31 && $score <= 60) {
            return 'Gaya belajar kamu adalah *Visual*. Kamu menyerap informasi lebih efektif melalui gambar, warna, diagram, dan tampilan visual lainnya 🖼';
        } elseif ($score >= 61 && $score <= 100) {
            return 'Gaya belajar kamu adalah *Kinestetik*. Kamu belajar terbaik melalui pengalaman langsung, praktik, atau aktivitas fisik ✋🧠';
        } else {
            return 'Skor tidak valid untuk gaya belajar. Harap cek kembali input asesmen.';
        }
    }

    // Default jika tipe tidak dikenali
    return 'Interpretasi tidak tersedia untuk jenis asesmen ini.';
}

}