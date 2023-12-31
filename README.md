# <img src="public/assets/icons/logo.png" width="40px"> Bhraman Travels
Responsive travel guide site exploring the Atlantic. Clean design, interactive features.

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MongoDB](https://img.shields.io/badge/MongoDB-%234ea94b.svg?style=for-the-badge&logo=mongodb&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)

### Overview
Explore the world with "Bhramn Travels," a captivating travel guide website. This repository encompasses a responsive and visually appealing HTML structure for seamless navigation. From the immersive "About Us" section detailing the passion for Atlantic exploration to the interactive "Explore" feature, users can select destinations of interest. The site boasts a clean design with a custom select menu, providing a user-friendly experience. The "Contact" section offers essential details, including address, phone, and email.

### Dependencies
The project is based on PHP and MongoDB, so we first have to install them, providing the installation command for Debian-based systems only.
```bash
sudo apt install -y php8.1
```
Install MongoDB extension
```bash
sudo pecl install mongodb
```

Add this to your `php.ini` to enable the mongoDB extension
```
extension=mongodb.so
```

### Installisation
You may either configure it with apache or nginx or run directly with **PHP CLI**.

Clone the reposority
```bash
git clone https://github.com/s0ubhik/bhramn-travels
cd bhramn-travels
```

Install Dependencies
```bash
composer install
```
In `.env` change the `MONGO_URL` with your MongoDB url
```ini
MONGO_URL=mongodb+srv://<username>:<password>@<host>
```

Start the server
```bash
cd public
php -S localhost:8080
```
### License
Distributed under the MIT License. See `LICENSE` for more information.

