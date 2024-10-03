1. ./vendor/bin/sail up -d
2. ./vendor/bin/sail artisan migrate
3. ./vendor/bin/sail artisan db:seed  ---> There will be 5 users created. User1, User2, User3, User4, User5 with password todo123
4. http://localhost/request-docs Go here for the documentation
5. Send Request to login with email: user1@example.com password: todo123
6. take token and put the token in request header like this:
   "Authorization": "Bearer Your Token here"
You can set global header with option "Set Global Headers" when you will click "send" on any endpoint.
7. After that you will be able to run any endpoint. 
8. You can also test the endpoints in Postman after downloading the collection from the link above.
9. In order to run scheduler, you need to run the following command:
   ./vendor/bin/sail artisan schedule:run 
10. Or you can manually run command from terminal:
    ./vendor/bin/sail artisan due-date:check
This one will dispatch a job and then ./vendor/bin/sail artisan queue:work should be executed. 
11. This will send the email. (Ofc it will need configuration in env side.)
12. title,description,task_status,due_date those fields are indexed in database. 
(It will make search fast but store/update/delete will be a bit slow)
