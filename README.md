Program can be ran in two ways:

    1. Using command line from root directory(/skeleton-commission-task-master)

        php index.php storage/csv/input.csv

        Where index.php - path to file where code is executed,
        store/csv/input.csv - path to input data file.
        
    2. In browser

        Input data file path is saved in variable $filePath in index.php file.
        In case file path changes, it should be changed in $filePath too.
        Opening root directory in browser (for example http://localhost/skeleton-commission-task-master/) outputs results.

Tests can be ran in command line using command

    composer run test
