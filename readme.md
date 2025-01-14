# M07_UF2_Intervention-monolog

This repository contains a project for CarWorkshop using Monolog, a popular logging library for PHP, and Intervention, an image handling and manipulation library for PHP.

## Requirements

- PHP 7.2 or higher
- Composer

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/M07_UF2_Intervention-monolog.git
    ```
2. Navigate to the project directory:
    ```sh
    cd M07_UF2_Intervention-monolog
    ```
3. Install the dependencies:
    ```sh
    composer install
    ```

## Usage

To use Monolog in your project, you can create a logger instance and start logging messages. Here is an example:

```php
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger instance
$logger = new Logger('my_logger');

// Add a handler
$logger->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::DEBUG));

// Add records to the log
$logger->info('This is an info message');
$logger->error('This is an error message');
```

To use Intervention in your project, you can create an image instance and perform various operations. Here is an example:

```php
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

// Open an image file
$image = Image::make('path/to/image.jpg');

// Resize the image
$image->resize(300, 200);

// Save the image
$image->save('path/to/resized_image.jpg');
```

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Acknowledgements

- [Monolog](https://github.com/Seldaek/monolog) - The logging library used in this project.
- [Intervention](https://github.com/Intervention/image) - The image handling and manipulation library used in this project.
