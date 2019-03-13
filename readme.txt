autoLogin.js
	Redirects a logged in user to chat.html when trying to login in

changePassword.php
	Sql queries to handle change password procedure
	
chat.html
	Styled page for loading and sending chat messages from dynamic document on server.
	
chat.js
	Helper functions for chat.html DEPRECATED

chat_engine.js
	Helper functions for chat.html

chat_style.css
	Test Chat Style DEPRECIATED

checkID.php
	Checks ID from Database

checkIfUsername.js
	Check if username matches session id

database.php
	Constructs Database, constructs queries, etc. Berrier code.

forgotPassword.php
	Sends new password via email

getAllInfo.php
	Gets all practical info for a user

getAllServerList.php
	Returns list of servers user does not belong to.

getFriendRequests.php
	Returns list of friend requests

getFriendsList.php
	Returns list of current user's friends

getServerInvites.php
	Returns list of server getServerInvites

getServerInfo.php
	Returns list of attributes for server.

getServerList.php
	Returns list of servers user belongs to.

getServerPermissions.php
	Returns current server permissions

home.css
	Styling for home.html

home.html
	Landing page for logged in user with friends, servers, invites.

home.js
	Handles queries for home.html

index.html
	Non-logged in landing page.

index.php
	Test Chat DEPRECIATED

instant_messages.css
	Styling for instant_messages.html

instant_messages.html
	Handles direct messages

login.html
	User login page

login.php
	Gets login info from database

loginStyle.css
	Styling for login.html

msgParse.js
	Helper functions for chat backend

navbar_template.html
	Template code for navbar on pages

package.json
	Info for node.js

process.php
	Sends and recieves chat messages

profile_page.html
	Displays user info from database

profilePageStyle.css
	Styles profile_page.html

profilePage.js
	Backend for loading profile_page.html data

register.html
	Page to allow users to register an account

register.php
	Database queries to register a user

respondFriendRequest.php
	Updates database to add/reject friend to user

respondFriendRequest.php
	Updates database to add/reject invite to server

script.js
	JS functions for modals and dropdowns

searchForUser.php
	Returns all usernames similar to inputted character sequence

server_settings.html
	Allows users to modify parameters of a server

server_settings.css
	Styling for server_settings.html

server.php
	Creates new private servers

style.css
	General unified styling attributes

userInfo.php
	Pulls user info from database

Design:

--Universal navbar design / or custom per page (profile page)
--Add CheckIfUsername.js to every page
--Folder System (html,JS,CSS,PHP) exluding index.html
--Website usability (get around the website w/o using address bar)
--Not using localhost username, using global variable
--start lower Camel case
--