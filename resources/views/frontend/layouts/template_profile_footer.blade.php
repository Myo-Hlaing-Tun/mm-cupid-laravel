<footer class="article-container-footer">
    <a href="{{ url('home') }}" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex align-items-center" id="Welcome">
            <i class="fa fa-home fs-4 me-1"></i>
            <span>Home</span>
        </button>
    </a>
    <button class="button is-ghost">
        <svg
            data-origin="pipeline"
            aria-hidden="true"
            viewBox="0 0 32 32"
            fill="none"
            width="25px"
        >
            <path
            d="M11.945 26.806a7.713 7.713 0 01-4.88-9.752l4.013-12.05a.665.665 0 00-.766-.865 4.82 4.82 0 00-.42.12l-6.45 2.15a5.03 5.03 0 00-1.404.73h-.002A5.03 5.03 0 000 11.183v.002c0 .54.087 1.078.258 1.59l4.826 14.479c.164.492.407.956.718 1.371a5.1 5.1 0 004.042 2.046h.012a5.03 5.03 0 001.586-.256l3.778-1.255a.666.666 0 000-1.265l-3.275-1.088z"
            fill="currentColor"
            ></path>
            <path
            d="M28.654 3.157a5.031 5.031 0 00-1.428-.749L20.774.258a5.03 5.03 0 00-6.365 3.183L9.595 17.896a5.032 5.032 0 00-.258 1.582v.012a5.031 5.031 0 001.999 4.023l.003.002c.438.33.926.587 1.447.76l6.438 2.139a5.03 5.03 0 001.586.256h.012a5.032 5.032 0 004.018-2.012l.003-.005c.325-.432.578-.915.748-1.427l4.817-14.451c.171-.513.259-1.05.259-1.591v-.002a5.031 5.031 0 00-2.013-4.025z"
            fill="currentColor"
            ></path>
        </svg>
        Encounter
    </button>
    <button class="button is-ghost text-secondary d-flex align-items-center">
        <i class="fa fa-heart fs-4 me-1"></i>
        <span>Likes</span>
    </button>
    <a href="{{ url('knowledge') }}" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex align-items-center" id="Knowledge">
            <i class="fa fa-pencil-square-o fs-4 me-1"></i>
            <span>Knowledge</span>
        </button>
    </a>
    <a href="{{ url('profile') }}" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex align-items-center" id="Profile">
            <i class="fa fa-user fs-4 me-1"></i>
            <span>Profile</span>
        </button>
    </a>
</footer>
<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js') }}"></script>
