# Build-AP

Build-AP analyzes patches 5.11 and 5.14 and provides insight into champion win rates as well as item utilization differences then provides a suggested build based on winrates.

### Demo
http://104.131.190.246/build-ap/index.html

### Findings
1. Get a Mejais
2. Get a Deathcap
3. Champions are dealing less damage on average than before the patch (no suprise here)
4. Although core AP items were nerfed, they are still being built because there's nothing else to build in place of their utility
5. Rylai's Crystal Scepter is being used alot more across the board (probably because it is now on par with the old core items)
6. Strange how people are building Void Staff less even though the value of AP items has decreased overall
7. TL;DR; People don't care that it's giving you less AP, they still build the same items.

### Champion/Item Specific Findings
1. Large increase in people building Nashor's Tooth and Rylai's Crystal Scepter on Azir. (http://104.131.190.246/build-ap/champion.html?do=Azir)
2. More people are building Liandry's Torment probably because % HP burn provides more power for some champions than flat AP now.
3. More people are finishing up Perfect Hex Core faster because it's a better AP source than other AP items.
4. There are still trolls building support gold per 10 items and going mid.
5. Soraka mid is a thing but people still get ardent censer.

### Technologies
* PHP
* MongoDB
* Bootstrap
* jQuery

### Installing/Compiling
1. Install MongoDB and PHP's MongoDB driver. MongoDB should have no password.
2. Go to the "fetch" folder and execute "php fetch-all-matches.php -i AP_ITEM_DATASET".
3. After all matches are imported into MongoDB, go to the "machine-learning" folder and execute "php generate-statistics.php".
4. Copy all files from the "website" folder to an apache or an nginx webserver and it should automatically display all the data. If not, make sure the mongo PECL package is installed.