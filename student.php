<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>CampusHub — Student Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style/custom.css" rel="stylesheet">
<link rel="stylesheet" href="style/student.css">
</head>
<body>


<nav class="nav-shell sticky-top px-3 px-lg-4 py-2" id="mainNav">
  <div class="container-fluid d-flex align-items-center gap-3">
    <a class="brand fs-4 text-decoration-none" href="student.php" style="color:var(--primary)" id="navBrand">
      <span style="color:var(--accent)">⬡</span> CampusHub
    </a>

    <div class="portal-tabs ms-auto me-auto d-none" id="navTabs">
      <button class="portal-tab active" data-tab="dashboard" id="tabBtnDashboard" onclick="switchTab('dashboard')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </button>
      <button class="portal-tab" data-tab="events" id="tabBtnEvents" onclick="switchTab('events')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Events
      </button>
      <button class="portal-tab" data-tab="profile" id="tabBtnProfile" onclick="switchTab('profile')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profile
      </button>
      <button class="portal-tab" data-tab="media" id="tabBtnMedia" onclick="switchTab('media')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        Media
      </button>
      <button class="portal-tab" data-tab="forms" id="tabBtnForms" onclick="switchTab('forms')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Forms
      </button>
      <button class="portal-tab" data-tab="announcements" id="tabBtnAnnouncements" onclick="switchTab('announcements')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Announcements
      </button>
      <button class="portal-tab" data-tab="communities" id="tabBtnCommunities" onclick="switchTab('communities')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        Communities
      </button>
    </div>

    
    <div class="position-relative d-none" id="notifBellWrap">
      <button class="btn btn-link p-1 position-relative" id="notifBellBtn" onclick="toggleNotifPanel()" style="color:var(--text)">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <span class="notif-badge d-none" id="notifBadge">0</span>
      </button>
      <div class="notif-panel" id="notifPanel">
        <div class="px-3 py-2 d-flex align-items-center justify-content-between">
          <span class="fw-semibold" style="font-size:.92rem">Notifications</span>
          <button class="btn btn-sm btn-link text-decoration-none" id="markAllReadBtn" onclick="markAllRead()" style="font-size:.78rem;color:var(--primary)">Mark all read</button>
        </div>
        <div id="notifList"></div>
      </div>
    </div>

    
    <div class="session-bar d-none" id="sessionBar">
      <div class="user-avatar" id="navUserAvatar"></div>
      <span class="fw-semibold d-none d-md-inline" id="navUserName" style="font-size:.88rem"></span>
      <button class="btn btn-sm btn-outline-primary rounded-pill px-3" id="logoutBtn" onclick="doLogout()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </button>
    </div>

    
    <button class="btn btn-primary btn-sm rounded-pill px-3" id="loginNavBtn" onclick="document.getElementById('authOverlay').classList.remove('hidden')">
      Sign In
    </button>
  </div>
</nav>


<div class="auth-overlay" id="authOverlay">
  <div class="auth-card">
    <div class="text-center mb-3">
      <span class="brand fs-3" style="color:var(--primary)"><span style="color:var(--accent)">⬡</span> CampusHub</span>
      <p class="text-muted mt-1 mb-0" style="font-size:.88rem">Student Portal Access</p>
    </div>
    <div class="auth-tabs">
      <button class="auth-tab active" id="authTabLogin" onclick="switchAuthTab('login')">Sign In</button>
      <button class="auth-tab" id="authTabRegister" onclick="switchAuthTab('register')">Register</button>
    </div>

    
    <form id="loginForm" onsubmit="doLogin(event)">
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Username</label>
        <input type="text" class="form-control" id="loginUsername" required placeholder="Enter username">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Password</label>
        <input type="password" class="form-control" id="loginPassword" required placeholder="Enter password">
      </div>
      <div id="loginError" class="text-danger mb-2" style="font-size:.82rem;display:none"></div>
      <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold" id="loginSubmitBtn">
        Sign In
      </button>
    </form>

    
    <form id="registerForm" style="display:none" onsubmit="doRegister(event)">
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Full Name</label>
        <input type="text" class="form-control" id="regFullName" required placeholder="John Doe">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Username</label>
        <input type="text" class="form-control" id="regUsername" required placeholder="johndoe">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Email</label>
        <input type="email" class="form-control" id="regEmail" required placeholder="john@university.edu">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Department</label>
        <select class="form-select" id="regDepartment">
          <option value="">Select Department</option>
          <option value="Computer Science">Computer Science</option>
          <option value="Engineering">Engineering</option>
          <option value="Business">Business</option>
          <option value="Arts">Arts</option>
          <option value="Science">Science</option>
          <option value="Medicine">Medicine</option>
          <option value="Law">Law</option>
          <option value="Education">Education</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:.85rem">Password</label>
        <input type="password" class="form-control" id="regPassword" required placeholder="Min 6 characters" minlength="6">
      </div>
      <div id="registerError" class="text-danger mb-2" style="font-size:.82rem;display:none"></div>
      <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold" id="registerSubmitBtn">
        Create Account
      </button>
    </form>
  </div>
</div>


<main class="container-fluid px-3 px-lg-4 py-4" style="max-width:1260px" id="mainContent">

  
  <section class="tab-section active" id="sectionDashboard">
    
    <div class="hero-panel p-4 p-md-5 mb-4" id="dashHero">
      <span class="section-label">Student Portal</span>
      <h1 class="hero-title mt-2" id="heroWelcome">Welcome back!</h1>
      <p class="hero-copy mt-2 mb-0" style="font-size:1.05rem">Track your events, manage your profile, and stay up to date with campus life.</p>
    </div>

    
    <div class="row g-3 mb-4" id="dashStatsRow">
      <div class="col-6 col-md-3">
        <div class="stat-card-portal d-flex align-items-center gap-3">
          <div class="icon-chip">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <div>
            <div class="metric" id="statEvents">—</div>
            <div class="metric-label">Events</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card-portal d-flex align-items-center gap-3">
          <div class="icon-chip" style="background:linear-gradient(135deg,#22c55e,#16a34a)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div>
            <div class="metric" id="statCommunities">—</div>
            <div class="metric-label">Communities</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card-portal d-flex align-items-center gap-3">
          <div class="icon-chip" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
          <div>
            <div class="metric" id="statMedia">—</div>
            <div class="metric-label">Media</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card-portal d-flex align-items-center gap-3">
          <div class="icon-chip" style="background:linear-gradient(135deg,#06b6d4,#0891b2)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
          </div>
          <div>
            <div class="metric" id="statForms">—</div>
            <div class="metric-label">Forms</div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="mb-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Upcoming Events</h5>
        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" id="viewAllEventsBtn" onclick="switchTab('events')">View All</button>
      </div>
      <div class="row g-3" id="dashEventsRow">
        <div class="col-12 text-center py-4"><div class="skeleton-line w-75 mx-auto"></div><div class="skeleton-line w-50 mx-auto"></div></div>
      </div>
    </div>

    
    <div class="mb-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">My Communities</h5>
        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="switchTab('communities')">View All</button>
      </div>
      <div class="row g-3" id="dashCommunitiesRow">
        <div class="col-12 text-center py-4"><div class="skeleton-line w-75 mx-auto"></div><div class="skeleton-line w-50 mx-auto"></div></div>
      </div>
    </div>

    
    <div class="mb-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Recent Announcements</h5>
        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" id="viewAllAnnouncementsBtn" onclick="switchTab('announcements')">View All</button>
      </div>
      <div id="dashAnnouncementsRow">
        <div class="skeleton-line w-75"></div><div class="skeleton-line w-50"></div>
      </div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionEvents">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
      <div>
        <span class="section-label">Campus Events</span>
        <h3 class="fw-bold mt-1 mb-0">Upcoming Events & Activities</h3>
      </div>
      <div class="d-flex gap-2">
        <input type="text" class="form-control form-control-sm" id="eventSearchInput" placeholder="Search events..." style="max-width:220px;border-radius:.8rem" oninput="filterEvents(this.value)">
      </div>
    </div>
    <div class="row g-3" id="eventsGrid">
      <div class="col-12"><div class="skeleton-line w-50 mx-auto"></div></div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionCommunities">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
      <div>
        <span class="section-label">Campus Organizations</span>
        <h3 class="fw-bold mt-1 mb-0">Discover Communities</h3>
      </div>
      <div class="d-flex gap-2">
        <input type="text" class="form-control form-control-sm" id="communitySearchInput" placeholder="Search communities..." style="max-width:220px;border-radius:.8rem" oninput="filterCommunities(this.value)">
      </div>
    </div>
    <div class="row g-3" id="communitiesGrid">
      <div class="col-12"><div class="skeleton-line w-50 mx-auto"></div></div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionProfile">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="glass-card profile-header" id="profileHeaderCard">
          <div class="user-avatar lg mx-auto mb-3" id="profileAvatar"></div>
          <h4 class="fw-bold mb-1" id="profileFullName">—</h4>
          <p class="text-muted mb-1" style="font-size:.88rem" id="profileEmail">—</p>
          <span class="pill" id="profileDepartment">—</span>
          <p class="mt-3 mb-3" style="font-size:.9rem;color:#4c1d95" id="profileBio">No bio set</p>
          <button class="btn btn-primary btn-sm rounded-pill px-4" id="editProfileBtn" onclick="openEditProfile()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Profile
          </button>
        </div>

        <div class="glass-card mt-3 p-3">
          <div class="d-flex justify-content-around">
            <div class="profile-stat-item">
              <div class="stat-num" id="profileStatEvents">0</div>
              <div class="stat-label">Events</div>
            </div>
            <div class="profile-stat-item">
              <div class="stat-num" id="profileStatCommunities">0</div>
              <div class="stat-label">Communities</div>
            </div>
            <div class="profile-stat-item">
              <div class="stat-num" id="profileStatMedia">0</div>
              <div class="stat-label">Media</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="fw-bold mb-0">My Event Registrations</h5>
        </div>
        <div id="myRegistrationsList">
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p class="mb-0">No registrations yet</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionMedia">
    <span class="section-label">Media Gallery</span>
    <h3 class="fw-bold mt-1 mb-4">Upload Photographs & Activity Updates</h3>

    
    <div class="glass-card p-4 mb-4">
      <div class="upload-dropzone" id="uploadDropzone" onclick="document.getElementById('fileInput').click()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        <p class="fw-semibold mb-1">Drag & drop files here or click to browse</p>
        <p class="text-muted mb-0" style="font-size:.82rem">Supports JPG, PNG, GIF, MP4, PDF, DOC — Max 50MB</p>
      </div>
      <input type="file" id="fileInput" class="d-none" accept=".jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.pdf,.doc,.docx" onchange="handleFileSelect(this)">
      <div class="mt-3 d-none" id="uploadPreview">
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <span class="pill" id="uploadFileName"></span>
          <select class="form-select form-select-sm" id="uploadCategory" style="max-width:160px;border-radius:.8rem">
            <option value="photo">Photo</option>
            <option value="video">Video</option>
            <option value="document">Document</option>
          </select>
        </div>
        <textarea class="form-control mt-2" id="uploadDescription" placeholder="Add a description..." rows="2"></textarea>
        <div class="d-flex gap-2 mt-2">
          <button class="btn btn-primary btn-sm rounded-pill px-4" id="uploadSubmitBtn" onclick="uploadMedia()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Upload
          </button>
          <button class="btn btn-outline-primary btn-sm rounded-pill px-3" id="uploadCancelBtn" onclick="cancelUpload()">Cancel</button>
        </div>
      </div>
    </div>

    
    <h5 class="fw-bold mb-3">My Uploads</h5>
    <div class="gallery-grid" id="mediaGallery">
      <div class="empty-state" style="grid-column:1/-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <p class="mb-0">No media uploaded yet</p>
      </div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionForms">
    <span class="section-label">Online Forms</span>
    <h3 class="fw-bold mt-1 mb-4">Available Forms</h3>
    <div class="row g-3" id="formsGrid">
      <div class="col-12"><div class="skeleton-line w-50 mx-auto"></div></div>
    </div>

    <div class="mt-5">
      <h5 class="fw-bold mb-3">My Submissions</h5>
      <div id="mySubmissionsList">
        <div class="empty-state">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <p class="mb-0">No submissions yet</p>
        </div>
      </div>
    </div>
  </section>

  
  <section class="tab-section" id="sectionAnnouncements">
    <span class="section-label">Announcements</span>
    <h3 class="fw-bold mt-1 mb-4">Campus Announcements & Notifications</h3>

    <div class="row g-4">
      <div class="col-lg-7">
        <h5 class="fw-semibold mb-3">All Announcements</h5>
        <div id="announcementsList">
          <div class="skeleton-line w-75"></div><div class="skeleton-line w-50"></div>
        </div>
      </div>
      <div class="col-lg-5">
        <h5 class="fw-semibold mb-3">My Notifications</h5>
        <div id="notificationsList">
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <p class="mb-0">No notifications</p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>


<footer class="text-center py-4 mt-4">
  <p class="footer-note mb-0" style="font-size:.82rem">&copy; 2026 <span class="brand">CampusHub</span>. All rights reserved.</p>
</footer>




<div class="modal fade modal-glass" id="eventDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="eventModalTitle">Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-7">
            <p id="eventModalDesc" class="mb-3"></p>
            <div class="d-flex flex-wrap gap-3 mb-3">
              <div class="d-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span id="eventModalDate" style="font-size:.9rem"></span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span id="eventModalLocation" style="font-size:.9rem"></span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 mb-3">
              <span class="badge badge-soft rounded-pill" id="eventModalCategory"></span>
              <span class="badge badge-live rounded-pill" id="eventModalCapacity"></span>
            </div>
          </div>
          <div class="col-md-5">
            <div class="glass-card p-3">
              <h6 class="fw-bold mb-2">Register for this Event</h6>
              <div id="eventModalGroups" class="mb-3"></div>
              <select class="form-select form-select-sm mb-3" id="eventGroupSelect">
                <option value="">No group / Select group</option>
              </select>
              <button class="btn btn-primary w-100 rounded-pill" id="eventRegisterBtn" onclick="registerForEvent()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>
                Register Now
              </button>
              <div id="eventRegMsg" class="mt-2" style="font-size:.82rem"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade modal-glass" id="communityDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header d-flex flex-column align-items-start gap-2">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <h4 class="modal-title fw-bold" id="communityModalTitle">Community</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="d-flex align-items-center gap-2 w-100">
          <span class="badge badge-soft rounded-pill" id="communityModalCategory"></span>
          <span class="text-muted" style="font-size:0.8rem" id="communityModalMembers"></span>
        </div>
      </div>
      <div class="modal-body" style="background:var(--bg)">
        <div class="row g-4">
          
          <div class="col-md-4">
            <h6 class="fw-bold mb-2">About</h6>
            <p id="communityModalDesc" class="text-muted small mb-4" style="line-height:1.6"></p>
            <h6 class="fw-bold mb-2">Recent Members</h6>
            <div id="communityModalMembersList" class="d-flex flex-wrap gap-2"></div>
          </div>
          
          <div class="col-md-8 d-flex flex-column" style="min-height: 400px;">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Community Feed</h6>
            <div id="communityModalFeed" class="flex-grow-1 overflow-auto pe-2 mb-3 d-flex flex-column gap-3" style="max-height: 350px;">
               
            </div>
            
            <div class="mt-auto bg-white p-3 rounded-4 border">
               <textarea id="communityPostText" class="form-control mb-2 bg-light border-0" rows="2" placeholder="Write a message to the community..." style="resize:none"></textarea>
               <div class="d-flex justify-content-between align-items-center">
                 <button class="btn btn-sm btn-outline-secondary rounded-pill" onclick="document.getElementById('communityPostMedia').click()">
                   <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                   Attach Media
                 </button>
                 <input type="file" id="communityPostMedia" class="d-none" accept=".jpg,.jpeg,.png,.gif,.mp4">
                 <button class="btn btn-sm btn-primary rounded-pill px-4 fw-bold" onclick="postCommunityMessage()">Post</button>
               </div>
               <div id="communityPostFileLabel" class="text-muted small mt-1 d-none"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade modal-glass" id="profileEditModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="profileEditForm" onsubmit="saveProfile(event)">
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem">Full Name</label>
            <input type="text" class="form-control" id="editFullName" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem">Phone</label>
            <input type="text" class="form-control" id="editPhone" placeholder="07X XXX XXXX">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem">Department</label>
            <select class="form-select" id="editDepartment">
              <option value="">Select</option>
              <option value="Computer Science">Computer Science</option>
              <option value="Engineering">Engineering</option>
              <option value="Business">Business</option>
              <option value="Arts">Arts</option>
              <option value="Science">Science</option>
              <option value="Medicine">Medicine</option>
              <option value="Law">Law</option>
              <option value="Education">Education</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem">Bio</label>
            <textarea class="form-control" id="editBio" rows="3" placeholder="Tell us about yourself..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100 rounded-pill" id="saveProfileBtn">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade modal-glass" id="formFillModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="formFillTitle">Fill Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-3" id="formFillDesc"></p>
        <form id="dynamicForm" onsubmit="submitForm(event)">
          <div id="formFieldsContainer"></div>
          <button type="submit" class="btn btn-primary rounded-pill px-4 mt-3" id="submitFormBtn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><polyline points="20 6 9 17 4 12"/></svg>
            Submit
          </button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="toast-container" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script/student.js"></script>
</body>
</html>

