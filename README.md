# JO-INF653-MidtermProject
The project involves developing Zippy Used Autos' PHP Web Application, including database creation, public homepage features, admin backend, MVC design, responsive design, Heroku deployment, and submission requirements.

## INF 653 - PHP Web Application Zippy Used Autos

**Author:** Jeramee Oliver  
**Date:** 3/10/2024  
**Course:** INF 653 - Back-End Dev

### Project Overview

This assignment involves creating a PHP ToDo List project for INF 653 - Back-End Dev. The project incorporates MVC, introduces categories, and refactors code. Students are instructed to set up a new GitHub repository, organize files, implement category functionality, and adapt textbook example code. The project utilizes PHP for server-side logic and MySQL for database interactions.

### Files

- **index.php:** The main PHP file responsible for displaying the ToDo List and handling form submissions.
- **model/database.php:** PHP script for establishing a connection to the MySQL database.
- **model/item_db.php:** PHP script for handling ToDo items in the database.
- **model/category_db.php:** PHP script for handling categories in the database.
- **view/header.php:** Header file for the HTML structure.
- **view/footer.php:** Footer file for the HTML structure.
- **view/error.php:** Error handling file for displaying error messages.
- **view/css/main.css:** CSS file for styling the application.
- **view/add.php:** Add items to the list on a separate page.
- **view/item_list.php:** Template for displaying ToDo items.
- **view/category_list.php:** Template for displaying categories.
- **.gitignore:** Configuration file for Git to ignore specific files and directories.

### Setup Instructions

1. Set up a MySQL database named "todolist" with tables "todoitems" and "categories" (refer to assignment requirements for table structure).
2. Update `database.php` with your actual database credentials.
3. Ensure that your server environment supports PHP and has PDO enabled for MySQL.
4. Run the PHP application on your server.

### Usage

- Access `index.php` to view and manage your ToDo List.
- Add new items using the provided form.
- Click "Remove" next to each item to delete it from the list and the database.
- Use the drop-down menu to filter items by category.

### Dependencies

- PHP 8.1.0
- MySQL

### Acknowledgments

*This project was created as part of the INF 653 course. Special thanks to the course instructor and resources provided.*

---

# Midterm Project Requirements

1. **Database Created:** Applied as required.
2. **Default Vehicle Display for Customers:** Applied as required.
3. **Display Functionality with Requested Sorting & Filters:** Functions as required.
4. **Zippy’s Backend Admin Pages:** All function as required.
5. **MVC Design Pattern Applied:** Functions as required.
6. **Responsive Design & Suitable Overall Appearance:** Functions as required.
7. **GitHub code repository:** Repository as required.
8. **Deployed to Heroku:** Deployed as required.
9. **One Page Discussion Document & Forum Post:** Full discussion and forum post as required.

## Extra Credit (Optional):

a. **Combine Filters:** Provide list results that combine desired make, type, and class. Update drop-down menus based on user choices.

b. **Dynamic Admin Footer:** Create an admin footer menu that adapts to the displaying page. Include logic to link only to other admin pages.

## Screenshots & Pointers

- Follow the provided screenshots for reference on expected appearance and functionality.
- Utilize the breakdown of project requirements and pointers provided in the document.
- No code updates after the due date for the Midterm Project.
- Keep a utilitarian design; functionality is key.
- Bootstrap may be used for responsiveness but is not mandatory.

### Submission:

1. **GitHub Repository:**
   - Link to your GitHub code repository.

2. **Heroku Deployment:**
   - Link to the deployed project on Heroku.

3. **Admin Backend:**
   - Link to Zippy’s “Back End Home Page.”

4. **Challenges Document:**
   - Submit a one-page PDF discussing challenges faced during the project.

5. **Blackboard Forum:**
   - Share the project and key discussion points in the final project forum on Blackboard.

### Notes:

- No code repo push updates after the due date accepted.
- Set up your files following the provided code structure and let me know if you have any questions or issues.