<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\UserAssessmentSession;
use App\Models\AssessmentResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PageController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function loginPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.assessments');
            }
        }
        return view('login');
    }

    public function registerPage()
    {
        return view('userReview\register');
    }

    public function adminDashboard(Request $request)
    {
        $username = $request->query('username', Auth::user()->name);
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;    
        $totalUsers = User::where('role_id', 2)->count();
        $totalAssessments = Assessment::count();
        $totalCompletedSessions = UserAssessmentSession::count();

        $totalCompletedSessions = UserAssessmentSession::whereMonth('taken_at', $currentMonth)
        ->whereYear('taken_at', $currentYear)
        ->count();

        $recentSessions = UserAssessmentSession::with(['user', 'assessment'])
            ->orderBy('taken_at', 'desc')
            ->take(5)
            ->get();

        $users = User::where('role_id', 2)->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('username', 'totalUsers', 'totalAssessments', 'totalCompletedSessions',
                                        'recentSessions', 'users'));
    }

    public function adminProfile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateAdminProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        $user->name = $request->name;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function assessmentManagement()
    {
        $assessments = Assessment::withCount('questions')->get();
        return view('pengelolaanassessment', compact('assessments'));
    }
    
    public function createAssessment()
    {
        return view('createassessment');
    }
    
    // public function editAssessment(Assessment $assessment)
    // {
    //     return view('admin.assessments.edit', compact('assessment'));
    // }
    
    public function manageQuestions(Assessment $assessment)
    {
        return view('questions', compact('assessment'));
    }

    public function userAssessments()
    {
        $assessments = Assessment::withCount('questions')->where('is_active', true)->get();
        $completedAssessments = UserAssessmentSession::where('user_id', Auth::id())
            ->pluck('assessment_id')
            ->toArray();
            
        return view('userReview\daftarassessmen', compact('assessments', 'completedAssessments'));
    }

    public function takeAssessment(Assessment $assessment)
    {
        $hasCompleted = UserAssessmentSession::where('user_id', Auth::id())
            ->where('assessment_id', $assessment->id)
            ->exists();
            
        if ($hasCompleted) {
            return redirect()->route('user.progress')
                ->with('message', 'Anda telah menyelesaikan asesmen ini sebelumnya.');
        }
        
        $questions = $assessment->questions()->with('options')->get();
        return view('userReview\userassessmen', compact('assessment', 'questions'));
    }

    public function userProfile()
    {
        $user = Auth::user();
        return view('userReview\profileUser', compact('user'));
    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        $user->name = $request->name;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    
    public function userProgress()
    {
        $sessions = UserAssessmentSession::with(['assessment', 'results'])
            ->where('user_id', Auth::id())
            ->orderBy('taken_at', 'desc')
            ->get();
            
        $assessmentData = [];
        foreach ($sessions as $session) {
            $assessmentName = $session->assessment->name;
            if (!isset($assessmentData[$assessmentName])) {
                $assessmentData[$assessmentName] = [];
            }

            $maxScore = $session->results->max('score');
            $assessmentData[$assessmentName][] = [
                'date' => $session->taken_at->format('d M Y'),
                'score' => $maxScore
            ];
        }
        
        return view('pemantauan', compact('sessions', 'assessmentData'));
    }
    
    public function viewResults(UserAssessmentSession $session)
    {

        if ($session->user_id !== Auth::id()) {
            abort(403);
        }
        
        $results = $session->results;
        $assessment = $session->assessment;
        
        return view('userReview\results', compact('session', 'results', 'assessment'));
    }
}