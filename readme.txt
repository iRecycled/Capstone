autoLogin.js
	Redirects a logged in user to chat.html when trying to login in
	TODO: direct to home.html

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

database.php
	Constructs Database, constructs queries, etc. Berrier code.

forgotPassword.php
	Sends new password via email

getAllServerList.php
	Returns list of servers user does not belong to.

getServerInfo.php
	Returns list of attributes for server.

getServerList.php
	Returns list of servers user belongs to.

home.css
	Styling for home.html

home.html
	Landing page for logged in user.

home.js
	Handles queries for home.html

index.html
	Non-logged in landing page.

index.php
	Test Chat DEPRECIATED

instant_messages.css
	Styling for instant_messages.html

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
	Sends and recieves chat messages DEPRECIATED

profile_page.html
	Displays user info from database

profilePageStyle.css
	Styles profile_page.html

register.html
	Page to allow users to register an account

register.php
	Database queries to register a user

script.js
	JS functions for modals and dropdowns

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
--