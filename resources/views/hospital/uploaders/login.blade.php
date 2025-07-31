{{-- resources/views/hospital/uploaders/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Uploader Login</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
    <!-- Left Side - Login Form -->
    <div class="flex items-center justify-center p-8 bg-white">
      <div class="w-full max-w-md">
        <!-- Blue Document Icon -->
        <div class="flex justify-center mb-8">
          <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>

        <!-- Welcome Text -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h1>
          <p class="text-gray-600">Sign in to your TeleRadiology account</p>
        </div>

        @if($errors->has('email'))
          <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ $errors->first('email') }}
          </div>
        @endif

        <form action="{{ route('uploader.login.submit') }}" method="POST" class="space-y-6">
          @csrf

          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Email Address
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
              </div>
              <input type="email"
                     id="email"
                     name="email"
                     required
                     autofocus
                     value="{{ old('email') }}"
                     placeholder="doctor@hospital.com"
                     class="w-full pl-10 pr-3 py-3 border-2 border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Password
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <input type="password"
                     id="password"
                     name="password"
                     required
                     placeholder="Enter your password"
                     class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                Remember me
              </label>
            </div>
            <div class="text-sm">
              <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                Forgot password?
              </a>
            </div>
          </div>

          <!-- Sign In Button -->
          <div>
            <button type="submit"
                    class="w-full flex justify-center items-center px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
              </svg>
              SIGN IN SECURELY
            </button>
          </div>
        </form>

        <!-- HIPAA Compliance -->
        <div class="mt-8 flex items-center justify-center text-sm text-gray-600">
          <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
          </svg>
          HIPAA Compliant & SSL Secured
        </div>
      </div>
    </div>

    <!-- Right Side - Blue Design -->
    <div class="hidden lg:flex items-center justify-center bg-blue-800 p-12">
      <div class="text-white max-w-lg">
        <!-- Checkmark Icon -->
        <div class="mb-8">
          <div class="w-16 h-16 bg-blue-700 bg-opacity-50 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>

        <!-- Main Heading -->
        <h2 class="text-4xl font-bold mb-6 leading-tight">
          Advanced Medical<br>
          <span class="text-green-400">Imaging</span>
        </h2>

        <!-- Description -->
        <p class="text-blue-100 text-lg mb-8 leading-relaxed">
          Empowering healthcare professionals with cutting-edge teleradiology solutions for accurate diagnosis and patient care.
        </p>

        <!-- Feature List -->
        <div class="space-y-4 mb-12">
          <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <span class="text-blue-100">High-Resolution DICOM Viewer</span>
          </div>

          <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <span class="text-blue-100">AI-Powered Diagnostic Tools</span>
          </div>

          <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <span class="text-blue-100">Secure Cloud Infrastructure</span>
          </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-2 gap-8 mb-8">
          <div>
            <div class="text-3xl font-bold text-green-400 mb-1">99.9%</div>
            <div class="text-blue-200 text-sm">Uptime</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-green-400 mb-1">24/7</div>
            <div class="text-blue-200 text-sm">Support</div>
          </div>
        </div>

        <!-- Quote -->
        <p class="text-blue-200 italic text-sm leading-relaxed">
          "Revolutionizing healthcare through innovative medical imaging technology and seamless collaboration."
        </p>
      </div>
    </div>
  </div>
</body>
</html>
