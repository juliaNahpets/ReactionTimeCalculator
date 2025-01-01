# Reaction Time Calculator

## Description

The **Reaction Time Calculator** is a Laravel Artisan command that calculates the reaction time within business hours (Monday to Friday, 8:00 AM to 6:00 PM), excluding national holidays. This tool is useful for measuring response times in applications where operations are restricted to business hours.

## Requirements

- PHP 8.2
- Laravel Framework
- [Carbon](https://carbon.nesbot.com/) library
- [Cmixin BusinessTime](https://github.com/codemonauts/business-time) package

## Installation

1. **Clone the Repository**

   ```bash
   git clone git@github.com:juliaNahpets/ReactionTimeCalculator.git
   cd reaction-time-calculator
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

## Usage

Run the Artisan command to calculate the reaction time:

```bash
php artisan calculate:reactiontime
```

You will be prompted to enter the start and end times in the format `DD.MM.YY HH:mm`. If no input is provided, default values will be used.

**Example:**

```bash
php artisan calculate:reactiontime
Enter the start time (Format: DD.MM.YY HH:mm) [default: 01.05.24 10:30]:
01.05.24 10:30
Enter the end time (Format: DD.MM.YY HH:mm) [default: 02.05.24 13:45]:
02.05.24 13:45
The calculated reaction time is: 13 hours and 15 minutes.
```

In this example:

- **Start Time:** 01.05.24 10:30 (Wednesday)
- **End Time:** 02.05.24 13:45 (Thursday)
- **Calculated Reaction Time:** 13 hours and 15 minutes

**Note:** Only the time within business hours (8:00 AM to 6:00 PM) on business days (Monday to Friday) is counted towards the reaction time.
