<header class="top-header">

    <div class="welcome-section">
        <h1>{{ $title ?? 'Dashboard' }}</h1>
    </div>

    <div class="header-actions">

        <div class="search-box">
            <input type="text"
                   id="globalSearch"
                   placeholder="Cari data..."
                   onkeyup="universalSearch()">
        </div>

        @auth
        <div class="profile-container">

            <div class="profile-section" id="profileBtn">

                <div class="profile-text">
                    <span class="name">
                        {{ Auth::user()->name }}
                    </span>
                </div>

                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>

            </div>

            <div class="profile-dropdown" id="profileDropdown">

                <div class="dropdown-header">
                    <span class="user-name">
                        {{ Auth::user()->name }}
                    </span>

                    <span class="user-email">
                        {{ Auth::user()->email }}
                    </span>
                </div>

                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item">
                        Profil Saya
                    </a>
                </div>

            </div>

        </div>
        @endauth

    </div>

</header>