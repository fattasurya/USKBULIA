<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #014421, #a8e6a3);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: #fff;
      border-radius: 25px;
      padding: 50px 35px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 10px 35px rgba(1, 68, 33, 0.3);
      position: relative;
    }

    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-header h1 {
      font-size: 28px;
      color: #014421;
      font-weight: 600;
    }

    .login-header p {
      color: #555;
      font-size: 14px;
    }

    .input-group {
      margin-bottom: 25px;
    }

    .input-group label {
      font-size: 15px;
      color: #222;
      margin-bottom: 8px;
      display: block;
      font-weight: 500;
    }

    .input-field {
      position: relative;
    }

    .input-field input {
      width: 100%;
      padding: 14px 16px;
      border-radius: 14px;
      border: 2px solid #e0e0e0;
      font-size: 15px;
      background-color: #f9fdf9;
      transition: all 0.3s;
    }

    .input-field input:focus {
      border-color: #2e7d32;
      background-color: #fff;
      outline: none;
      box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    .input-field input::placeholder {
      color: #aaa;
    }

    .toggle-password {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .toggle-password:hover {
      color: #2e7d32;
    }

    .submit-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 14px;
      font-size: 16px;
      font-weight: 600;
      background: linear-gradient(to right, #2e7d32, #66bb6a);
      color: white;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: 0 5px 15px rgba(46, 125, 50, 0.2);
    }

    .submit-btn:hover {
      background: linear-gradient(to right, #1b5e20, #43a047);
      transform: translateY(-1px);
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #555;
    }

    .register-link a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      font-size: 13px;
      color: #d32f2f;
      margin-top: 5px;
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

    
    </form>
  </div>

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
