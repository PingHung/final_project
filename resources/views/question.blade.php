@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Question</div>

                    <div class="card-body">
                        {{$question->body}}
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary float-right"
                           href="{{ route('question.edit',['id'=> $question->id])}}">
                            Edit Question
                        </a>
                        {{ Form::open(['method'  => 'DELETE', 'route' => ['question.destroy', $question->id]])}}
                        <button class="btn btn-danger float-right mr-2" value="submit" type="submit" id="submit">Delete
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-header"><a class="btn btn-primary float-left"
                                                href="{{ route('answers.create', ['question_id'=> $question->id])}}">
                            Answer Question
                        </a></div>

                    <div class="card-body">
                        @forelse($question->answers as $answer)
                            <div class="card" >
                                <div class="card-body">{{$answer->body}}</div>
                                <div class="card-footer" data-answerid= "{{ $answer->id }}">

                                    <div class="interaction float-left">
                                        <a href="#"
                                           class="vote">{{ Auth::user()->votes()->where('answer_id', $answer->id)->first() ? Auth::user()->votes()->where('answer_id', $answer->id)->first()->vote == 1 ? 'You vote up this answer' : 'Vote Up' : 'Vote Up'}}</a>
                                        /
                                        <a href="#"
                                           class="vote">{{ Auth::user()->votes()->where('answer_id', $answer->id)->first() ? Auth::user()->votes()->where('answer_id', $answer->id)->first()->vote == 0 ? 'You vote down this answer' : 'Vote Down' : 'Vote Down'  }}</a>
                                    </div>

                                    <a class="btn btn-primary float-right"
                                       href="{{ route('answers.show', ['question_id'=> $question->id,'answer_id' => $answer->id]) }}">
                                        View
                                    </a>

                                </div>
                            </div>
                        @empty
                            <div class="card">

                                <div class="card-body"> No Answers</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>


            <script>
                var token = '{{ Session::token() }}';
                var urlVote = '{{ route('vote') }}';
            </script>
@endsection