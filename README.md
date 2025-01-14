# 2Moons-Bots

## Overview
This repository provides bot scripts for the 2Moons browser game engine. These bots are designed to enhance the gaming experience by simulating player activity in a server-friendly manner.

### Features of Bots
- **Fleet Management**: Each bot manages a fleet with resource and income generation capabilities.
- **Planet Interaction**: Fleets land on randomly selected planets owned by the bot, depositing resources since the last landing.
- **Growth Mechanism**: Fleets grow over time and can be targeted for attacks if timed correctly (hunting game loop).
- **Resource Protection**: Smaller fleets are used to protect resources on planets from smaller players.

### Variations in Bot Types
Bots can be customized with various parameters:
- Resource allocation per ship type.
- Percentage of ships left on planets upon lift-off.
- Distribution of resources between production and ship building.
- Duration of fleet stays in space or on a planet.
- Different bot types and associated fleets.
- Multipliers for first player points as bots gain resource contingents each month based on first players points.
- Ratio of resource distribution among metal, deuterium, and crystal and ships.

### Approach
Unlike traditional bots that mimic human players, these bots focus on creating a game loop rather than replicating player behavior. This approach aims to be server-friendly while maintaining an engaging gaming environment.

## Installation

1. **Copy Files**: Copy the bot files into your 2Moons game directory.
   
2. **Modify `admin.php`**:
   Add the following code snippet to handle the bot management page in the admin section:
    ```php
    case 'editbots': // New case for bots
       include_once('includes/pages/adm/ShowEditBotsPage.php'); // Ensure this file exists
       ShowEditBotsPage();
       break;
    ```

3. **Modify `styles/templates/adm/ShowMenuPage.tpl`**:
   Add a menu entry for bot management in the admin interface:
   ```html
   {if allowedTo('ShowEditBotsPage')}
       <li><a href="?page=editbots" target="Hauptframe">Edit Bots</a></li>
   {/if}
   ```

## Usage

- **Admin Interface**: Use the new "Edit Bots" option in the admin menu to manage and configure bots.

### Creating and Managing Bots
1. **Create a Bot**:
   - Navigate to the "Edit Bots" page via the admin menu.
   - Click on the option to create a new bot.
   - Configure the bot's parameters, such as resource allocation, ship types, and fleet sizes.

2. **Automatic Setup**:
   - Once a bot is created, all necessary cron jobs and database tables are automatically set up.
   - The bot will begin its activities immediately after creation.

3. **Bot Activities**:
   - Initially, the bot will not perform any actions then beeing in space or on planet.
   - On each land lift circle it gains resoures and ships

Feel free to contribute or modify the bot scripts to better suit your server's needs!

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contributions
Contributions are welcome! Please submit issues or pull requests if you have improvements or bug fixes.
  
## Contact
For any inquiries, please reach out via the GitHub repository.

---

Enjoy your enhanced 2Moons game experience with these server-friendly bots!

