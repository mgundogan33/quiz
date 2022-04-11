<x-app-layout>
    <x-slot name="header">Quizler</x-slot>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('quizzes.create') }}" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i>
                    Quiz Oluştur</a>
                @if(request()->get('title') || request()->get('status'))
                <a href="{{ route('quizzes.index') }}" class="btn btn-warning btn-sm ">Sıfırla</a>
                @endif
            </h5>
            <form method="GET" action="">
                <div class="form-now">
                    <div class="col-md-3">
                        <input type="text" name="title" value="{{ request()->get('title') }}" placeholder="Quiz Adı"
                            class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" onchange="this.form.submit()" name="status">
                            <option value="">Durum Seçiniz</option>
                            <option @if (request()->get('status') == 'publish') selected @endif value="publish">Aktif</option>
                            <option @if (request()->get('status') == 'passive') selected @endif value="passive">Pasif</option>
                            <option @if (request()->get('status') == 'draft') selected @endif value="draft">Taslak</option>
                        </select>
                    </div><br>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Quiz</th>
                        <th scope="col">Soru Sayısı</th>
                        <th scope="col">Durum</th>
                        <th scope="col">Bitiş Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($quizzes as $quiz)
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->questions_count }}</td>
                            <td>
                                @switch($quiz->status)
                                    @case('publish')
                                        <span class="btn btn-success">Aktif</span>
                                    @break

                                    @case('passive')
                                        <span class="bbtn btn-danger">Pasif</span>
                                    @break

                                    @case('draft')
                                        <span class="btn btn-warning">Taslak</span>
                                    @break
                                @endswitch

                            </td>
                            <td>
                                <span
                                    title="{{ $quiz->finished_at }}">{{ $quiz->finished_at ? $quiz->finished_at->diffForHumans() : '-' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-question"></i></a>

                                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pen"></i></a>
                                <a href="{{ route('quizzes.destroy', $quiz->id) }}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $quizzes->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
