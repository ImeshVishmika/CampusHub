<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusHub - Admin Portal</title>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Righteous&display=swap" rel="stylesheet">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
    <link rel="stylesheet" href="style/custom.css">
    
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>


<div id="access-denied">
    <div class="p-5 stat-card glass-modal" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h1 class="font-righteous text-primary mb-2"><i class="bi bi-shield-lock-fill"></i> Admin Login</h1>
            <p class="text-muted">Enter your credentials to access the Administrator Portal.</p>
        </div>
        <form id="form-admin-login" onsubmit="loginAdmin(event)">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" class="form-control" id="admin-username" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control" id="admin-password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Secure Login</button>
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted text-decoration-none" style="font-size: 0.85rem;"><i class="bi bi-arrow-left"></i> Return to Home</a>
            </div>
        </form>
    </div>
</div>

<div class="admin-layout" id="admin-layout" style="display:none;">
    
    
    <aside class="admin-sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-hexagon-fill"></i> CampusHub
        </a>
        <nav class="sidebar-nav">
            <div class="nav-item active" onclick="switchTab('tab-dashboard')" id="nav-dashboard">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </div>
            <div class="nav-item" onclick="switchTab('tab-students')" id="nav-students">
                <i class="bi bi-people-fill"></i> Students
            </div>
            <div class="nav-item" onclick="switchTab('tab-events')" id="nav-events">
                <i class="bi bi-calendar-event-fill"></i> Events & Reg
            </div>
            <div class="nav-item" onclick="switchTab('tab-media')" id="nav-media">
                <i class="bi bi-images"></i> Media
            </div>
            <div class="nav-item" onclick="switchTab('tab-content')" id="nav-content">
                <i class="bi bi-file-earmark-richtext-fill"></i> Content
            </div>
            <div class="nav-item" onclick="switchTab('tab-orgs')" id="nav-orgs">
                <i class="bi bi-diagram-3-fill"></i> Organizations
            </div>
            
            <div class="nav-item logout" onclick="logout()">
                <i class="bi bi-box-arrow-left"></i> Logout
            </div>
        </nav>
    </aside>

    
    <main class="admin-main">
        
        
        <header class="topbar">
            <h2 class="topbar-title" id="topbar-title">Dashboard Overview</h2>
            <div class="topbar-actions">
                <button class="btn-icon btn-icon-primary"><i class="bi bi-bell-fill"></i></button>
                <div class="admin-profile">
                    <div class="admin-avatar" id="admin-initial">A</div>
                    <span id="admin-name">Administrator</span>
                </div>
            </div>
        </header>

        
        <div id="tab-dashboard" class="tab-pane active">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Total Students</div>
                        <div class="value" id="stat-students">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Active Events</div>
                        <div class="value" id="stat-events">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Communities</div>
                        <div class="value" id="stat-communities">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Announcements</div>
                        <div class="value" id="stat-announcements">0</div>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="tab-students" class="tab-pane">
            <div class="data-table-glass">
                <div class="data-table-header">
                    <h3 class="data-table-title">Student Records</h3>
                    <button class="btn btn-primary btn-sm" onclick="loadStudents()"><i class="bi bi-arrow-clockwise"></i> Refresh List</button>
                </div>
                <div class="table-responsive">
                    <table id="table-students">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name / Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div id="tab-events" class="tab-pane">
            <div class="data-table-glass">
                <div class="data-table-header">
                    <h3 class="data-table-title">Events Management</h3>
                    <button class="btn btn-primary" onclick="openEventModal()"><i class="bi bi-plus-lg"></i> Create Event</button>
                </div>
                <div class="table-responsive">
                    <table id="table-events">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div id="tab-media" class="tab-pane">
            <div class="data-table-glass mb-4">
                <div class="data-table-header">
                    <h3 class="data-table-title">Upload New Media</h3>
                </div>
                <div class="p-4">
                    <label class="upload-zone" for="media-upload-input">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <p>Click to browse or drag & drop files here</p>
                        <span class="badge-soft badge-soft-primary">Accepted formats: Images & Video (Max 5MB)</span>
                        <input type="file" id="media-upload-input" class="d-none" accept="image/*,video/*">
                    </label>
                </div>
            </div>
            
            <h4 class="mb-3 font-righteous text-primary" style="font-family: 'Righteous', cursive;">Media Gallery</h4>
            <div class="media-grid" id="media-grid">
                
            </div>
        </div>

        
        <div id="tab-content" class="tab-pane">
            <div class="row g-4">
                <div class="col-xl-6">
                    <div class="data-table-glass h-100">
                        <div class="data-table-header">
                            <h3 class="data-table-title">Announcements</h3>
                            <button class="btn btn-primary btn-sm" onclick="openAnnouncementModal()"><i class="bi bi-plus-lg"></i> New</button>
                        </div>
                        <div class="table-responsive">
                            <table id="table-announcements">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="data-table-glass h-100">
                        <div class="data-table-header">
                            <h3 class="data-table-title">Forms</h3>
                            <button class="btn btn-primary btn-sm" onclick="openFormModal()"><i class="bi bi-plus-lg"></i> New</button>
                        </div>
                        <div class="table-responsive">
                            <table id="table-forms">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="tab-orgs" class="tab-pane">
            <div class="data-table-glass">
                <div class="data-table-header">
                    <h3 class="data-table-title">Communities & Organizations</h3>
                    <button class="btn btn-primary" onclick="openCommunityModal()"><i class="bi bi-plus-lg"></i> Add Community</button>
                </div>
                <div class="table-responsive">
                    <table id="table-communities">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Community Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>




<div class="modal fade glass-modal" id="modal-event" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-modal-title">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-event">
                    <input type="hidden" id="ev-id">
                    <div class="mb-3">
                        <label class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="ev-title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="ev-desc" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date & Time</label>
                            <input type="datetime-local" class="form-control" id="ev-date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" id="ev-loc" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacity (0 for unlimited)</label>
                        <input type="number" class="form-control" id="ev-cap" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="form-event" class="btn btn-primary">Save Event</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade glass-modal" id="modal-registrations" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Registrations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="table-registrations">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade glass-modal" id="modal-announcement" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Publish Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-announcement">
                    <div class="mb-3">
                        <label class="form-label">Announcement Title</label>
                        <input type="text" class="form-control" id="ann-title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" id="ann-content" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="form-announcement" class="btn btn-primary">Publish</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade glass-modal" id="modal-form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-form">
                    <div class="mb-3">
                        <label class="form-label">Form Title</label>
                        <input type="text" class="form-control" id="form-title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="form-desc" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="form-form" class="btn btn-primary">Save Form</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade glass-modal" id="modal-community" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="community-modal-title">Create Community</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-community">
                    <input type="hidden" id="com-id">
                    <div class="mb-3">
                        <label class="form-label">Community Name</label>
                        <input type="text" class="form-control" id="com-name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="com-desc" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="form-community" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="toast-container position-fixed bottom-0 end-0 p-4" id="toast-container"></div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="script/admin.js"></script>
</body>
</html>

