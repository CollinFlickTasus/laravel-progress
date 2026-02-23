# Laravel Progress Driver

A custom Laravel database driver for **Progress/OpenEdge** connections.  
Provides a working Eloquent connection with support for custom query grammars.

---

## Features

- Fully  with Laravel 12
- Supports Eloquent queries.
- Optional grammar/processor overrides via connection config
- Works out-of-the-box with minimal setup as long as you have your DSN set up correctly.

---

## Installation

### Step 1: Require the package

You can either install directly from GitHub or via Composer path repository for local development.

#### GitHub (recommended)

```bash
composer require collinflicktasus/laravel-progress