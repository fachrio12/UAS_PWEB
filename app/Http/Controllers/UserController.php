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
        
        // Create a new assessment session
        $session = UserAssessmentSession::create([
            'user_id' => Auth::id(),
            'assessment_id' => $assessment->id,
        ]);
        
        // Record user answers
        foreach ($validated['answers'] as $questionId => $optionId) {
            UserAnswer::create([
                'session_id' => $session->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);
        }
        
        // Process and calculate results
        $this->calculateResults($session);
        
        return redirect()->route('user.results', $session->id)
            ->with('success', 'Asesmen berhasil diselesaikan!');
    }
    
    private function calculateResults(UserAssessmentSession $session)
    {
        // Get all answers from the session
        $answers = $session->answers()->with('option')->get();
        
        // Example: Calculate results based on total scores
        // Group by some category (this would depend on your specific assessment logic)
        $categories = [];
        
        // For this example, we'll just use a simple summing of scores
        $totalScore = 0;
        
        foreach ($answers as $answer) {
            $totalScore += $answer->option->score;
        }
        
        // Create a simple result
        AssessmentResult::create([
            'session_id' => $session->id,
            'result_category' => 'Overall Score',
            'score' => $totalScore,
            'interpretation' => $this->getInterpretation($totalScore),
        ]);
        
        // Example for motivation factors (simplified)
        MotivationFactor::create([
            'session_id' => $session->id,
            'factor_name' => 'Engagement',
            'score' => min(100, $totalScore * 5), // Just a sample calculation
        ]);
    }
    
    private function getInterpretation($score)
    {
        // Simple interpretation logic - you would customize this based on your assessment type
        if ($score >= 80) {
            return 'Anda memiliki pemahaman yang sangat baik. Pertahankan!';
        } elseif ($score >= 60) {
            return 'Anda memiliki pemahaman yang baik. Terus tingkatkan!';
        } elseif ($score >= 40) {
            return 'Anda memiliki pemahaman yang cukup. Ada beberapa area yang perlu ditingkatkan.';
        } else {
            return 'Anda perlu meningkatkan pemahaman. Silakan pelajari lebih lanjut.';
        }
    }
}