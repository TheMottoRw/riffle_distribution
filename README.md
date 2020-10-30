### Police armory and riffle distribution management

This project it intended for management of riffle distribution

### Setup this project
<b>Note: root</b> stands for armory folder if the name is not changed
   - Clone to your computer
   - You should have XAMPP installed for windows or LAMPP for linux
   - Import database from <b>root/api/database/armory.sql</b>
   - Change database user to yours from <b>root/api/classes/Database.php</b> replace <b>super</b> with the one you use
   - Depends on the path where you put project files,modify url address in <b>root/api_access.php</b> Line 3 and 21 to the one you use
   - Then,web is set well now setup its android application from www.github.com/themottorw/riffle_distribution_app


#### Users and Privileges

- <b>Superadmin</b> is in charge of registering all police and weapon and assign police in charge of deployment to their respected unit
- <b>Deployer</b> is in charge of registering posts,and assign police to post
- <b>Riffle_distributor</b> in charge of distributing riffles to police
#### Credentials
- Superadmin 
    - Phone: 0726183049
    - Password: 12345
    
- Deployer 
   - Phone: 0789012378
   - Password: 12345

    
- Riffle_distributor [In charge of deployment]
   - Phone: 0789012378
   - Password: 12345
