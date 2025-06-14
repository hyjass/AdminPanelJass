This is a secure and fully functional Admin Panel built using Laravel that implements Role-Based Access Control (RBAC). It allows different types of users (Admin and User) to access only the data they are permitted to see and interact with. Admins can manage users, while users can only view and modify their own information.

✅ Key Features:
Role-Based Access Control (RBAC):
-Users with the "User" role can only view, update, and manage their own data.
-Admins have elevated access, allowing them to manage (view, edit, delete) all users except other admins.
-Access to specific pages and functions is strictly controlled based on the user's assigned role.

Authentication & Authorization:
-Laravel’s built-in Auth system is used for handling login, registration, and session management.
-Authorization is enforced using role-checking middleware to prevent unauthorized access to protected routes.
-Users are redirected to appropriate dashboards based on their role after login.

User Management:
-Admins can create new users through a secure form, assigning appropriate roles.
-Admins have the ability to edit or delete any regular user from the system.
-Regular users can access an edit form to update only their personal data, not other users.

🛡️ Middleware Protection
Route-Level Middleware:
-Specific routes are protected using custom middleware that checks user roles (admin/user).
-Only authenticated users can access the dashboard, and unauthorized users are redirected.
-Attempts to access restricted pages (like admin panel by user) are denied with proper error messages or redirection.

Custom Role Middleware:

-Middleware like isAdmin and isUser is created to separate logic and restrict role-specific routes.
-Admin-only pages are inaccessible to users, preventing data leaks or unauthorized management.
-The middleware improves code maintainability and enhances route security.

Session & Auth Checks:
-Laravel's auth middleware ensures only logged-in users can interact with the application.
-Session expiration and logout are handled gracefully to maintain data privacy.
-Authenticated sessions include user role information for easy role checking.

🧑‍💻 Admin Functionalities
Add New User:
-Admins can register a new user by filling in name, email, password, and selecting the role.
-Form validations are applied to ensure secure and clean data entry.
-Upon creation, users are stored in the database with encrypted passwords.

Edit & Delete Users:
-Admins can access a table listing all users (excluding other admins) with edit and delete buttons.
-Edit form allows updating user information including name, email, and role.
-Delete option is protected with confirmation prompts to avoid accidental deletions.

User Listing:
-A dynamic user table displays all users along with role-specific filters and search functionality.
-Pagination is applied for easy navigation of large user lists.
-Admin can monitor user data from a centralized dashboard.

👤 User Functionalities
Profile Access & Update:
-Users can view their own data upon login via a user dashboard.
-A dedicated form is available for updating profile information like name, email, etc.
-Password change option can be added for security enhancement.

Restricted Access:
-Users cannot view or access any admin-related pages or other users' data.
-Unauthorized attempts are blocked via middleware and users are redirected.
-User role is automatically assigned during registration (or by admin).

Dashboard Overview:
-After login, users are redirected to a personalized dashboard with relevant data.
-No admin-level functionality is exposed to users.
-Simple and clean UI allows for smooth navigation of user-specific features.

⚙️ Technologies Used
Backend:
-Laravel Framework , using MVC architecture for structured development.
-Laravel Auth system for secure authentication and session handling.
-MySQL database for storing users and role-related data.

Frontend:
-Blade Templating Engine used for dynamic views and layout inheritance.
-HTML5, CSS3, and Bootstrap 5 for a responsive and clean user interface.
-Optional JavaScript/jQuery for UI enhancements and interactivity.

Security & Best Practices:
-Passwords are hashed using Laravel’s bcrypt hashing method.
-CSRF protection is enabled across all forms.
-Validation is implemented on both frontend and backend to prevent invalid or malicious data.


