<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доступ к документации API</title>
    <script src={{asset('js/tailwind4.js')}}></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
<div class="max-w-md w-full space-y-8 p-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Документация Easydocx</h2>
            <p class="text-gray-600 mt-2">Введите пароль для доступа к документации</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-700 text-sm">{{ $errors->first('password') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <span class="text-red-700 text-sm">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                <span class="text-green-700 text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('docs.authenticate') }}" class="space-y-6">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Пароль
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Введите пароль">
            </div>

            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                Войти в документацию
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                Документация защищена паролем для обеспечения безопасности API
            </p>
        </div>
    </div>
</div>

<script>
    // Автофокус на поле пароля
    document.getElementById('password').focus();

    // Простая анимация при ошибке
    @if($errors->any())
    document.querySelector('.bg-red-50').classList.add('animate-pulse');
    setTimeout(() => {
        document.querySelector('.bg-red-50')?.classList.remove('animate-pulse');
    }, 2000);
    @endif
</script>
</body>
</html>
