<div class="section profile-heading content">
    <div class="columns">
        <div class="column is-2">
            <div class="image is-128x128 avatar">
                <img src="{{ Auth::user()->infos()->where('key','avatar')->value('value') ?: 'https://www.gravatar.com/avatar/' . md5( Auth::user()->email ) . '?d=retro' }}">
            </div>
        </div>
        <div class="column is-4 name">
            <p>
                <span class="title is-bold">{{ Auth::user()->name }}</span><br>
                <span class="subtitle is-4">{{ Auth::user()->roles()->first()->display_name }}</span>
                {{-- <span class="button is-primary is-outlined follow">Follow</span> --}}
            </p>
            <a href="{{ url('account') }}" class="is-link">Edit Profile</a>
            <p class="tagline">
                {{ Auth::user()->infos()->where('key','address')->value('value') ?: '' }}<br>
                {{ Auth::user()->infos()->where('key','contact')->value('value') ?: '' }}
            </p>
        </div>
    </div>
</div>
<div class="profile-options content">
    <div class="tabs is-fullwidth">
        <ul>
            <li class="link  {{ $tab=='activity' ? 'is-active' : '' }}"><a href="{{ url('parent') }}"><span class="icon"><i class="fa fa-rss"></i></span> <span>Dashboard</span></a></li>
            <li class="link  {{ $tab=='lessons' ? 'is-active' : '' }}"><a href="{{ url('parent/lessons') }}"><span class="icon"><i class="fa fa-book"></i></span> <span>Lessons</span></a></li>
            <li class="link  {{ $tab=='grades' ? 'is-active' : '' }}"><a href="{{ url('parent/grades') }}"><span class="icon"><i class="fa fa-file-text-o"></i></span> <span>Grades</span></a></li>
        </ul>
    </div>
</div>
