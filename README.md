#  🔐 Laravel Role-Based Access Control Admin Panel:

This is a secure and fully functional Admin Panel built using Laravel that implements Role-Based Access Control (RBAC). It allows different types of users (Admin and User) to access only the data they are permitted to see and interact with. Admins can manage users, while users can only view and modify their own information.

#  ✅ Key Features:

##   🔒 Role-Based Access Control (RBAC)

Users with the "User" role can only view, update, and manage their own data.

Admins have elevated access, allowing them to manage (view, edit, delete) all users except other admins.

Access to specific pages and functions is strictly controlled based on the user's assigned role.

##   🔑 Authentication & Authorization

Laravel’s built-in Auth system is used for login, registration, and session management.

Authorization is enforced using role-checking middleware to prevent unauthorized access.

Users are redirected to appropriate dashboards based on their role after login.

##  👥 User Management

Admins can create new users through a secure form and assign roles.

Admins have the ability to edit or delete any regular user from the system.

Users can edit only their own data, ensuring privacy and control.

# 🛡️ Middleware Protection:

##  📌 Route-Level Middleware

Routes are protected using custom middleware that checks user roles (admin / user).

Only authenticated users can access dashboards, others are redirected.

Attempts to access restricted pages (e.g., admin panel by user) are denied gracefully.

##  🧱 Custom Role Middleware

Middleware like isAdmin and isUser is used to separate logic for role-specific routes.

Admin-only pages are inaccessible to users, ensuring data isolation.

Enhances security and keeps route structure clean and maintainable.

##  🔐 Session & Auth Checks

Laravel's auth middleware ensures only logged-in users can access the system.

Sessions are handled smoothly with logout and expiration for privacy.

Authenticated sessions include user role data for efficient permission checks.

# 🧑‍💻 Admin Functionalities:

##  ➕ Add New User

Admins can register a user by providing name, email, password, and role.

All inputs are validated for clean and secure data entry.

User data is saved to the database with hashed passwords.

##  ✏️ Edit & Delete Users

Admins can view a list of all users (excluding other admins) with action buttons.

Edit form allows updating of user name, email, and role.

Delete action includes a confirmation prompt for safety.

##  📋 User Listing

A dynamic user table shows all users with search and filter options.

Pagination is enabled for easy handling of large datasets.

Admins can monitor user data from a central dashboard.

👤 User Functionalities:

🧾 Profile Access & Update

Users can view and manage their own data after login via a user dashboard.

Dedicated form is available for updating personal information.

Optional password change feature for added security.

##  🚫 Restricted Access

Users are not allowed to access admin pages or other users’ data.

Unauthorized access attempts are blocked using middleware.

User roles are assigned automatically during registration or by admin.

##  📊 Dashboard Overview

Users are redirected to a personalized dashboard after login.

No admin-level options are visible to regular users.

Interface is clean and user-focused for easy navigation.

# ⚙️ Technologies Used:

##  🔧 Backend

Laravel Framework, using MVC architecture for structured code.

Laravel Auth System for secure authentication and session management.

MySQL database for storing users and role-related data.

##  🎨 Frontend

Blade Templating Engine for dynamic views and layout extension.

HTML5, CSS3, Bootstrap 5 for responsive and user-friendly UI.

Optional JavaScript/jQuery for enhancing interactivity.

##  🔐 Security & Best Practices

Passwords are hashed using Laravel’s bcrypt hashing.

CSRF protection is enabled for all forms.

