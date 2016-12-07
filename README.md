# ruxup

API links:

get token: (POST) https://ruxup.herokuapp.com/backend/public/index.php/api/login

get user data (GET) https://ruxup.herokuapp.com/backend/public/index.php/api/login/profile (use token as header)

logout/invalidate token: (GET) https://ruxup.herokuapp.com/backend/public/index.php/api/logout/profile (use token as header)

create event (POST) https://ruxup.herokuapp.com/backend/public/index.php/api/create_event (use request with following parameters: name, location, start_time(timestamp), end_time(timestamp), category, owner_id, description(not required), image(not required).

get events that user with 'id' joined (GET) https://ruxup.herokuapp.com/backend/public/index.php/api/getEvents/{id} (id of user)

get events that user with 'id' created (GET) https://ruxup.herokuapp.com/backend/public/index.php/api/getEventsOwner/{id} (id of user)

get all users that belongs to the event with 'id' (GET) https://ruxup.herokuapp.com/backend/public/index.php/api/getUsers/{id} (id of event)


