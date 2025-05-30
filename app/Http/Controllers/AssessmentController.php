<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Option;

class AssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);
        $validated['is_active'] = true;
    
        $assessment = Assessment::create($validated);

        return redirect()->route('admin.questions', $assessment->id)
        ->with('success', 'Asesmen berhasil dibuat, silakan tambahkan pertanyaan!');
    }
    
    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);
        
        $assessment->update($validated);
        
        return redirect()->route('admin.assessments')
            ->with('success', 'Asesmen berhasil diperbarui!');
    }
    
    public function destroy(Assessment $assessment)
    {
        // Check if assessment has been used in sessions
        $hasBeenUsed = $assessment->sessions()->exists();
        
        if ($hasBeenUsed) {
            return redirect()->route('admin.assessments')
                ->with('error', 'Asesmen tidak dapat dihapus karena sudah digunakan oleh pengguna.');
        }
        
        // Delete all related questions and options
        foreach ($assessment->questions as $question) {
            $question->options()->delete();
        }
        $assessment->questions()->delete();
        
        // Delete the assessment
        $assessment->delete();
        
        return redirect()->route('admin.assessments')
            ->with('success', 'Asesmen berhasil dihapus!');
    }
    
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'question_text' => 'required|string',
            'options' => 'required|array',
            'options.*.option_text' => 'required|string',
            'options.*.score' => 'required|integer',
        ]);
    
        $question = Question::create([
            'assessment_id' => $validated['assessment_id'],
            'question_text' => $validated['question_text'],
        ]);
    
        foreach ($validated['options'] as $option) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $option['option_text'],
                'score' => $option['score'],
            ]);
        }
    
        return redirect()->route('admin.questions', $validated['assessment_id'])
            ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function multiStore(Request $request)
{
    foreach ($request->questions as $questionData) {
        $question = Question::create([
            'assessment_id' => $request->assessment_id,
            'question_text' => $questionData['question_text'],
        ]);

        foreach ($questionData['options'] as $option) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $option['option_text'],
                'score' => $option['score'],
            ]);
        }
    }

    return redirect()->back()->with('success', 'Semua pertanyaan berhasil ditambahkan!');
}

    
    public function updateQuestion(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.id' => 'sometimes|exists:options,id',
            'options.*.option_text' => 'required|string',
            'options.*.score' => 'required|integer',
        ]);
        
        // Update question
        $question->update([
            'question_text' => $validated['question_text'],
        ]);
        
        // Handle options
        $existingOptionIds = [];
        
        foreach ($validated['options'] as $optionData) {
            if (isset($optionData['id'])) {
                // Update existing option
                $option = Option::find($optionData['id']);
                $option->update([
                    'option_text' => $optionData['option_text'],
                    'score' => $optionData['score'],
                ]);
                $existingOptionIds[] = $option->id;
            } else {
                // Create new option
                $option = Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['option_text'],
                    'score' => $optionData['score'],
                ]);
                $existingOptionIds[] = $option->id;
            }
        }
        
        // Delete options that weren't in the update
        Option::where('question_id', $question->id)
            ->whereNotIn('id', $existingOptionIds)
            ->delete();
        
        return redirect()->route('admin.questions', $question->assessment_id)
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }
    
    public function destroyQuestion(Question $question)
    {
        $assessmentId = $question->assessment_id;
        
        // Delete options
        $question->options()->delete();
        
        // Delete question
        $question->delete();
        
        return redirect()->route('admin.questions', $assessmentId)
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }
}