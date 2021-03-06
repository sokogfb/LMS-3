@extends('layouts.app')

@section('content')
    <div class="container profile ">

        @include('card-profile-teacher',[
            'tab' => 'students'
        ])

        <div class="spacer"></div>
        <div class="box">
            <div class="container">
                <div class="content">
                    <a href="{{ url('teacher/student/create') }}" class="button is-primary">Add Student</a>
                    @if(isset($_GET['section']) && $_GET['section']!='All Sections')
                        <a href="{{ url('teacher/student/archive?section='.$_GET['section']) }}" class="button is-warning">Archive Section</a>

                    @endif
                    <p class="control is-pulled-right">
                        <span class="select">
                            <select id="select-section">
                                <option>All Sections</option>
                                @foreach ($sections as $key => $section)
                                    <option {{ isset($_GET['section']) && $section->value === $_GET['section'] ? 'selected' : '' }}>{{ $section->value }}</option>
                                @endforeach
                            </select>
                        </span>
                    </p>


                </div>
            </div>
        </div>
        <div class="box">
            <p class="control has-text-right content">
                <label class="checkbox">
                    <input type="checkbox" name="remember" {{ isset($_GET['showarchived']) && $_GET['showarchived'] ? 'checked' : ''}}>
                    @php
                    $url = request()->url();
                    $vars = [];
                    if(isset($_GET['section'])){
                        $vars['section'] = $_GET['section'];
                    }

                        $vars['showarchived'] = isset($_GET['showarchived']) && $_GET['showarchived'] ? false : true;
                    $url .= '?' . http_build_query($vars);
                    @endphp
                    <a href="{{ $url }}">Display archived students</a>
                </label>
            </p>
            @if($students->count()>0)
                @foreach ($students as $key => $student)
                    <article class="media" style="{{ $student->infos()->where('key','isarchived')->value('value') ? 'opacity:0.5;' : '' }}">


                        <div class="media-left">
                            <figure class="image is-64x64">
                                <img src="{{ $student->infos()->where('key','avatar')->value('value') ?: 'https://www.gravatar.com/avatar/' . md5( $student->email ) . '?d=retro' }}" alt="Image">
                            </figure>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>{{ $student->name }}</strong> <small>{{ $student->email }}</small> <small style="float:right;">{{ $student->updated_at->diffForHumans() }}</small>
                                </p>
                                <div class="columns">
                                    <div class="column">
                                        <p>
                                            <label><strong>Section</strong> : {{ $student->infos()->where('key','section')->value('value') ?: '-' }}</label><br>
                                            <label><strong>ID Number</strong> : {{ $student->infos()->where('key','idnum')->value('value') }}</label><br>
                                            <label><strong>Birthday</strong> : {{ $student->infos()->where('key','birthday')->value('value') }}</label>
                                        </p>
                                    </div>
                                    <div class="column">
                                        <p>
                                            @if($student->parent)
                                                <label><strong>Parent&apos;s Name</strong> : {{ $student->parent->name }}</label><br>
                                                <label><strong>Parent&apos;s Email</strong> : {{ $student->parent->email }}</label><br>
                                            @endif
                                            @if($student->grade()->count())
                                                <label><strong>Final Grade</strong> : {{  number_format($student->grade()->avg('grade'),2) }}%</label>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <nav class="level">
                                <div class="level-left">
                                    <a href="{{ url('teacher/student/'. $student->id . '/edit') }}" class="level-item has-icon">
                                        <span class="icon is-small"><i class="fa fa-pencil"></i></span>
                                        <small>&nbsp;EDIT</small>
                                    </a>
                                    <a href="{{ url('teacher/student/'. $student->id . '/delete') }}" class="level-item has-icon">
                                        <span class="icon is-small"><i class="fa fa-trash-o"></i></span>
                                        <small>&nbsp;DELETE</small>
                                    </a>
                                    @if($student->parent)
                                        <a href="{{ url('teacher/student/'. $student->id . '/parent/edit') }}" class="level-item has-icon">
                                            <span class="icon is-small"><i class="fa fa-pencil"></i></span>
                                            <small>&nbsp;EDIT PARENT</small>
                                        </a>
                                    @else
                                        <a href="{{ url('teacher/student/'. $student->id . '/parent/create') }}" class="level-item has-icon">
                                            <span class="icon is-small"><i class="fa fa-plus"></i></span>
                                            <small>&nbsp;ADD PARENT</small>
                                        </a>
                                    @endif
                                    <a href="{{ url('teacher/student/'. $student->id . '/grades/edit') }}" class="level-item has-icon">
                                        <span class="icon is-small"><i class="fa fa-bar-chart-o"></i></span>
                                        <small>&nbsp;EDIT GRADES</small>
                                    </a>
                                    @if($student->infos()->where('key','isarchived')->value('value'))
                                        <a href="{{ url('teacher/student/'. $student->id . '/archive/0') }}" class="level-item has-icon">
                                            <span class="icon is-small"><i class="fa fa-unlock"></i></span>
                                            <small>&nbsp;UNARCHIVE</small>
                                        </a>
                                    @else
                                        <a href="{{ url('teacher/student/'. $student->id . '/archive/1') }}" class="level-item has-icon">
                                            <span class="icon is-small"><i class="fa fa-lock"></i></span>
                                            <small>&nbsp;ARCHIVE</small>
                                        </a>
                                    @endif
                                </div>
                            </nav>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="notification is-primary">
                    No Students to display
                </div>
            @endif
        </div>

        @if($students->hasPages())
            <div class="box">
                {{ $students->links('vendor.pagination.simple-bulma') }}
            </div>
        @endif
    </div>
@endsection
