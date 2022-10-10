# Nextcloud Document Management System App

This app allows to filter and sort documents more conveniently on nextcloud
 
## Installation
To install it change into your Nextcloud's apps directory:

    cd nextcloud/apps

Paste the app to the apps folder. 

Then install the dependencies using:

    make composer

Install app on your nextcloud apps dashboard

## Frontend development

The frontend of the app is written using [Vue.js](https://vuejs.org/). To build the frontend code after doing changes to its source in `src/` requires to have Node and npm installed.

- 👩‍💻 Run `make dev-setup` to install the frontend dependencies
- 🏗 To build the Javascript whenever you make changes, run `make build-js`

To continuously run the build when editing source files you can make use of the `make watch-js` command.

## Backend development
Example of how to create a new table for nextcloud and integrate it:
	


First the table in the mysql database has to be created.

			• open the DMS/lib/Migration/Version0000... 
			describe the schema in this file
			• go to nextcloud root folder, where the occ files is
			• run sudo -u www-data php ./occ migrations:execute appname 		 
              000000Date20181013124731
			

Create Controllers

		DMS/lib/Controller/TableNameApiController
		DMS/lib/Controller/TableNameController

Create functions for accessing data

		• DMS/lib/Db/TableName
		• DMS/lib/Db/TableNameMapper

Create Service

		• DMS/lib/Service/TableNameService
        
Add methods to DMS/appinfo/routes.php 
		
		example of GET method:
		`['name' => 'namespace#index', 'url' => '/endpointName', 'verb' => 'GET', 'postfix' => 'endpointname'],
	
From frontend you can now call the endpoint using axios like this:

	 `axios.get(generateUrl('/apps/DMS/endpointName'))`
	 

## Additional info

	 -------------
	In order for multiple users to be able to see the same files and folders nextcloud group folders must be used - https://apps.nextcloud.com/apps/groupfolders
	 
	 -------------
	 
	Group Folders MUST be named the same as their descriptive names in src/table/tableInfo.json
	 ----------
	 
    Migration commands only work when nextcloud debug mode is enabled.

	--------------
	Table sorting, filters and pagination is based on Vuejs Smart table, it's documentation can be found here: https://tochoromero.github.io/vuejs-smart-table/
	

			
