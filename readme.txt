autoLogin.js
	Redirects a logged in user to chat.html when trying to login in

blockUser.php
	Adds blocked user to database and kicks from server

changePassword.php
	Sql queries to handle change password procedure

changeUserAvatar.php
	Changes a user's avatar parameter
	
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

checkIM.php
	Check if IM file already exists

createIM.php
	Creates IM instance in database

database.php
	Constructs Database, constructs queries, etc. Berrier code.

deleteServer.php
	Deletes server from database

demoteUser.php
	Changes a user's permissions in a specified server.

forgotPassword.php
	Sends new password via email

getAllInfo.php
	Gets all practical info for a user

getAllServerList.php
	Returns list of servers user does not belong to.

getBlockedUsers.php
	Returns list of blocked users

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

getServerMembers.php
	Returns list of server members

getServerList.php
	Returns list of servers

getServerName.php
	Returns name of specified server

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

isOnline.php
	Returns what users are currently online

loadIM.php
	Returns instant messages between two users

login.html
	User login page

login.php
	Gets login info from database

loginStyle.css
	Styling for login.html

msgParse.js
	Helper functions for chat backend DEPRECIATED

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

promoteUser.php
	Allow for user promotion to ownership

register.html
	Page to allow users to register an account

register.php
	Database queries to register a user

removeUser.php
	Removes user from server

respondFriendRequest.php
	Updates database to add/reject friend to user

respondServerInvite.php
	Updates database to add/reject invite to server

script.js
	JS functions for modals and dropdowns

searchForUser.php
	Returns all usernames similar to inputted character sequence

sendFriendRequest.php
	Adds friend request to server

sendPasswordEmail.php
	Sends reset password email

sendServerInvite.php
	Adds server invite to server

server_settings.html
	Allows users to modify parameters of a server

server_settings.css
	Styling for server_settings.html

server_settings.js
	Scripts for handling server_settings.html

server.php
	Creates new private servers

setOnline.php
	Sets the user to be online

style.css
	General unified styling attributes

userInfo.php
	Pulls user info from database

unblockUser.php
	Unblocks the current user

Design:

--Universal navbar design / or custom per page (profile page)
--Add CheckIfUsername.js to every page
--Folder System (html,JS,CSS,PHP) exluding index.html
--Website usability (get around the website w/o using address bar)
--Not using localhost username, using global variable
--start lower Camel case
--