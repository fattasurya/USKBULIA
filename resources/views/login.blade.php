<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      font-family: 'Roboto', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #e7f1ff, #f5f7fa);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #333;
      overflow: hidden;
    }

    .login-container {
      background: #fff;
      border-radius: 12px;
      padding: 40px 30px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeIn 0.5s ease-out;
    }

    .login-container:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
      transform: translateY(-2px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
      text-align: center;
      margin-bottom: 25px;
    }

    .login-header h1 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #0056b3;
      letter-spacing: 0.5px;
    }

    .login-header p {
      font-size: 0.95rem;
      font-weight: 300;
      color: #6c757d;
      margin-top: 5px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      font-size: 0.9rem;
      font-weight: 500;
      color: #333;
      margin-bottom: 8px;
      display: block;
      letter-spacing: 0.3px;
    }

    .input-field {
      position: relative;
    }

    .input-field input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 8px;
      border: 1px solid #dfe6e9;
      font-size: 0.9rem;
      background: #fafafa;
      color: #333;
      transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
    }

    .input-field input:focus {
      border-color: #007bff;
      background: #fff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
      outline: none;
    }

    .input-field input::placeholder {
      color: #adb5bd;
      font-weight: 300;
    }

    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
      font-size: 1rem;
      transition: color 0.3s;
    }

    .toggle-password:hover {
      color: #007bff;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      background: linear-gradient(to right, #007bff, #0056b3);
      color: #fff;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
      box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
    }

    .submit-btn:hover {
      background: linear-gradient(to right, #0056b3, #003d80);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .submit-btn:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      font-weight: 400;
      color: #6c757d;
    }

    .register-link a {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .register-link a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .error-message {
      font-size: 0.85rem;
      font-weight: 400;
      color: #dc3545;
      margin-top: 6px;
      display: block;
      letter-spacing: 0.2px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h1>Masuk Akun</h1>
      <p>Silakan login untuk melanjutkan</p>
    </div>

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="input-group">
        <label for="email">Email</label>
        <div class="input-field">
          <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <div class="input-field">
          <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
          <i class="fa fa-eye-slash toggle-password" onclick="togglePassword()"></i>
          @error('password')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <button type="submit" class="submit-btn">Masuk</button>

  

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.querySelector(".toggle-password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
      }
    }
  </script>
</body>
</html>