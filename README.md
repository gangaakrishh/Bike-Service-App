Bike Service Application

The application provides backend APIs to streamline registration for administrators and Customers, along with CRUD functionalities for service management and status updates. Customers can initiate service bookings, prompting email notifications to the administrator. Furthermore, upon service completion by the provider, Customers promptly receive email notifications with updated service statuses. Upon Customer login, a JWT token is generated containing their Customer ID and email, facilitating seamless booking processes by retrieving Customer information for further processing.

Process to run the files : 

1. Please accept the collaborator request and clone the repository to your local machine using GitHub Desktop. Store it in the      directory "youdir/xammp/htdocs".
2. Update Composer by executing the command "composer update".
3. Migrate the table with the command "php spark migrate".
4. Ensure to update your database configurations in the .env file.
5. To execute the code, use the command "php spark serve".
6. Import the Postman Collections into Postman and utilize the endpoints provided to perform operations.

End Points:

1. Customer Registraion and Login
2. Admin Login
3. Services and Service Status CRUD Operations
4. Customer Service Booking and got a service request through an mail to the admin
5. Once a service updated the Customer got an email
6. Customers can know about their applied service through the login 