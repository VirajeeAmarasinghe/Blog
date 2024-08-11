# Drupal Blog Application

## Overview
This project is a Drupal-based blog application with custom functionality for managing blog posts and user roles. It includes features for both administrators and editors, allowing for flexible content management.

## Prerequisites
- PHP 8.3 or higher
- MySQL 8.0 or higher
- Drupal 10.x
- Composer

## Installation Instructions

### 1. Download and Set Up Drupal

1. **Download Drupal:**
   - Obtain the latest version of Drupal from [Drupal.org](https://www.drupal.org/download).

2. **Extract Drupal:**
   - Extract the downloaded Drupal archive to your web server's root directory (e.g., `C:\xampp\htdocs\`).

3. **Set Up Database:**
   - Create a new database using MySQL.
   - Import the provided SQL dump file (`crud_blog_db.sql`) into the database using phpMyAdmin or a similar tool.

4. **Configure Settings:**
   - Copy `sites/default/default.settings.php` to `sites/default/settings.php`.
   - Edit `settings.php` to include your database connection details:

     ```php
     $databases['default']['default'] = array(
       'database' => 'your_database_name',
       'username' => 'your_database_user',
       'password' => 'your_database_password',
       'host' => 'localhost',
       'port' => '3306',
       'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
       'driver' => 'mysql',
     );
     ```

### 2. Enable Custom Module and Theme

1. **Custom Module:**
   - Copy the `blog_module` directory to `modules/custom/`.
   - Enable the custom module via Drupal's admin interface or using Drush:

     ```bash
     drush en blog_module -y
     ```

2. **Custom Theme:**
   - Copy the `your_theme` directory to `themes/custom/`.
   - Enable the theme via Drupal's admin interface or using Drush:

     ```bash
     drush theme:enable your_theme
     ```

### 3. Configure Permissions and Roles

- **Roles and Permissions:**
  - Admin: Able to approve/reject blog posts, manage users, and set publish dates.
  - Editor: Able to create, edit, and preview blog posts.

- **Permissions Configuration:**
  - Navigate to `People` > `Permissions` in the Drupal admin interface.
  - Assign appropriate permissions to the Admin and Editor roles as defined in the `blog_module.permissions.yml` file.

### 4. Access and Manage the Site

1. **Access the Site:**
   - Open your web browser and navigate to `http://localhost` to view the Drupal site.

2. **Manage Blog Posts:**
   - Editors can create, edit, and preview blog posts via the Drupal admin interface.
   - Admins can manage all blog posts, users, and site settings.

### 5. Custom Features

- **Preview Feature:**
  - A custom preview functionality is available, accessible via the "Preview" button on the blog post form.

- **Custom Workflow:**
  - Blog posts can be set to various statuses (Draft, Ready to Publish, Reject, Published, Archived) based on the workflow defined in the module.

## Troubleshooting

- **Common Issues:**
  - Ensure that all required PHP extensions are installed and configured.
  - Check file permissions for the `sites/default/files` directory.


## Additional Notes

- **Code Quality:** The code adheres to Drupal coding standards and best practices.
- **Security:** Proper security measures have been implemented, including permission checks and data validation.

Thank you for using the Drupal Blog Application!

