<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::withCount('questions');

        if (request()->get('title')) {
            $quizzes = $quizzes->where('title', 'LIKE', "%" . request()->get('title') . "%");
        }
        if (request()->get('status')) {
            $quizzes = $quizzes->where('status', request()->get('status'));
        }
        $quizzes = $quizzes->paginate(5);
        return view('admin.quiz.list', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizCreateRequest $request)
    {
        Quiz::create($request->post());
        return redirect()->route('quizzes.index')->withSuccess('Quiz Başaraıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::withCount('questions')->find($id) ?? abort(404, 'Quiz Bulunamadı');
        return view('admin.quiz.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizUpdateRequest $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        Quiz::whereId($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'finished_at' => $request->finished_at,
            'slug'   => Str::slug($request->title, '-')
        ]);

        return redirect()->route('quizzes.index')->withSuccess('Quiz güncelleme işlemi başarıyla gerçekleşti');
        Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı');
        $quiz->delete();
        return redirect()->route('quizzes.index')->withSuccess('Quiz silme işlemi başarıyla gerçekleşti');
    }
}
