# Courier Delivery Cost Calculator (Laravel)

This repository contains a Laravel-based command-line application to calculate courier delivery costs.  
It supports calculation via direct command-line arguments as well as JSON file input.

---

## 📦 Requirements

Ensure the following are installed on your system:

- PHP >= 8.0
- Composer
- Laravel environment
- Git

---

## 🚀 Installation & Setup

Follow these steps to set up the project locally.

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd <project-directory>
````

---

### Step 2: Install Composer Dependencies

```bash
composer install
```

---

### Step 3: Environment Setup

Rename the sample environment file:

```bash
cp .env.sample .env
```

Generate the application key:

```bash
php artisan key:generate
```

---

## 🧮 Usage

### Command 1: Calculate Courier Delivery Cost via CLI Parameters

Use this command to calculate the delivery cost by passing values directly.

```bash
php artisan app:calculate-courier-delivery-cost \
--baseCost=100 \
--weight=10 \
--distance=100 \
--offerCode=OFR003
```

#### Parameters:

| Parameter   | Description                  |
| ----------- | ---------------------------- |
| `baseCost`  | Base delivery cost           |
| `weight`    | Weight of the package        |
| `distance`  | Delivery distance            |
| `offerCode` | Optional discount offer code |

---

### Command 2: Calculate Courier Delivery Cost Using JSON File

Use this command to calculate delivery costs from a JSON input file.

```bash
php artisan courier:calculate --file=input.json
```

#### Notes:

* The JSON file must exist in the project root or a valid path must be provided.
* This command is useful for processing multiple packages at once.

---

## 📄 Sample `input.json`

```json
{
  "baseCost": 100,
  "packages": [
    {
      "id": "PKG1",
      "weight": 5,
      "distance": 50,
      "offerCode": "OFR001"
    },
    {
      "id": "PKG2",
      "weight": 10,
      "distance": 100,
      "offerCode": "OFR003"
    }
  ]
}
```

---

## 🧪 Running Tests (Optional)

If tests are available, run:

```bash
php artisan test
```
Here is the local run sample.
<img width="1536" height="618" alt="image" src="https://github.com/user-attachments/assets/529059c5-adcb-4a3e-bb86-dba6c3df38e1" />


---

## ℹ️ Notes

* Ensure `.env` configuration is correct before running commands.
* Offer codes are validated internally.
* This project is intended for CLI usage only.

---

## 👨‍💻 Author

**Krunal Palaniya**

---

## 📜 License

This project is licensed under the MIT License.

```
