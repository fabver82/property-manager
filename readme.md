# Property Manager

## The client's request

Our client owns several properties on a tropical island. He would like to have a website that will advertise his properties.
He will need an admin page to control the availabilities as he might also get bookings from agent or popular booking websites.
The owner will take care of the pictures, so he needs to add them to the property pages, as well as all details about the properties. He might also get new property to manage in the future.

On the client side, the owner want them to be able to see a calendar with the price for each property. Price can vary depending on the seasons. 
The client should then be able to book a property trough the system. Once the owner receive it, he will take care of the rest ( payment,confirmation, etc...).

The project will be divided in three priority stages.

1. Create and edit details of each property + other infos/pages and a contact page for inquiries. 
2. add a booking manager system with possibility to block/open dates and add external bookings. 
3. improve booking system with automations and follow up with client account.


##  Stage 1 

The admin can edit his front pages by adding new property and their details and extra "common pages" such as services.

#### Owner can : 
 - authenticate to admin page
 - CRUD properties ( including details and gallery)
 - set a minimum price/property. ("from" price)
 - edit common information about the location, the services and/or the activities on site
 or near the property. => common page

#### Client can :
 - see the list of properties on a main page.
 - make an inquiry trough a booking form or contact page ( Owner will send more information by email)
## pages
### front pages
 1. index (contain a summary of each property and common pages)
 2. property detail => pictures with caption, price, nb of bedrooms, pool desc, map
 3. other informational pages (location, services) with at least one picture and a formated text
 4. About the host ( optional)
 5. contact page (inquiry form) => client must enter c/i and c/o date.

### admin pages
 1. CRUD properties
    1. type (Condo, Villa, Others)
    2. number of bedrooms
    3. minimum price
    4. Description text
    5. Location coordinates and map
    6. pool (shared,private,none).
    7. gym (shared,private, none).
    8. list of pictures with caption (at least one for each room)
 2. CRUD pages
    1. title ( services, location, any other info)
    2. list of pictures
    3. description text
 3. CRUD pictures
    1. caption
    2. copy link
    3. can be "common" or "property" picture.
 4. settings
    1. edit admin/host infos

## stage 2

Owner can
 - Check/update booking requests ( => confirmed booking will make the property unavailable for those dates)
 - close/open dates and add external bookings
 - have a list of upcoming bookings and clients informations.
 - add//edit price per date/seasons

Client can :
 - see the available properties for the chosen dates with the adjusted price.
 - add special request to the booking form

## stage 3

Owner can:

 - synchronize airbnb/booking.com calendar 
 - follow/edit booking status from request to Check-out. ( deposit, full payment, electricity)
 - have statistics about clients and incomes/outcomes

Client can : 
 - have an account
 - make special request (chef, concierge, maintenance, activities, transfer)

