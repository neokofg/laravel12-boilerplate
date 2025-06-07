<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $endpoints['info']['title'] ?? 'API Documentation' }}</title>
    <script src={{asset('js/tailwind4.js')}}></script>
    <script src={{asset('js/alpine3.js')}} defer></script>
    <link rel="stylesheet" href={{asset('css/prism-tommorow.css')}}>
    <script src={{asset('js/prism-core.js')}}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
</head>
<body class="bg-gray-50" x-data="apiDocs()">
<!-- Top Navigation -->
<nav class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-900">
                    {{ $endpoints['info']['title'] ?? 'API Documentation' }}
                </h1>
                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        v{{ $endpoints['info']['version'] ?? '1.0.0' }}
                    </span>
            </div>
            <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        Сессия: {{ floor((config('docs.session_lifetime', 120) - (now()->diffInMinutes(session('docs_auth_time', now())))) / 60) }}ч {{ (config('docs.session_lifetime', 120) - (now()->diffInMinutes(session('docs_auth_time', now())))) % 60 }}м
                    </span>
                <form method="POST" action="{{ route('docs.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                        Выйти
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="flex">
    <!-- Sidebar -->
    <div class="w-80 bg-white shadow-lg">
        <div class="fixed w-80 h-full overflow-hidden">
            <div class="p-6 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                <p class="text-gray-600">{{ $endpoints['info']['description'] ?? 'API Documentation' }}</p>
                <div class="mt-4 p-3 bg-white rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800 font-medium">Base URL:</p>
                    <code class="text-xs text-blue-600 break-all">{{ $endpoints['info']['base_url'] ?? config('app.url') . '/api/v1' }}</code>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 h-full overflow-y-auto pb-32 sidebar-nav">
                @if(isset($endpoints['groups']))
                    @foreach($endpoints['groups'] as $groupId => $group)
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3 flex items-center">
                                <span class="h-2 w-2 bg-blue-500 rounded-full mr-2"></span>
                                {{ $group['name'] }}
                            </h3>
                            <ul class="space-y-1">
                                @if(isset($group['endpoints']))
                                    @foreach($group['endpoints'] as $endpointId => $endpoint)
                                        <li>
                                            <a href="#{{ $groupId }}-{{ $endpointId }}"
                                               class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 transition-colors duration-150"
                                               @click="activeEndpoint = '{{ $groupId }}-{{ $endpointId }}'">
                                    <span class="method-badge method-{{ strtolower($endpoint['method']) }} mr-2">
                                        {{ $endpoint['method'] }}
                                    </span>
                                                <span class="truncate">{{ $endpoint['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endforeach
                @endif
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 max-w-4xl">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-700 text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Authentication Info -->
        @if(isset($endpoints['authentication']))
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-900 mb-2 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    {{ $endpoints['authentication']['type'] ?? 'Аутентификация' }}
                </h2>
                <p class="text-blue-800 mb-3">{{ $endpoints['authentication']['description'] ?? '' }}</p>
                <div class="bg-blue-100 rounded-md p-3">
                    <code class="text-blue-800 text-sm font-mono">
                        {{ $endpoints['authentication']['header'] ?? 'Authorization: Bearer {token}' }}
                    </code>
                </div>
            </div>
        @endif

        <!-- Endpoints by Groups -->
        @if(isset($endpoints['groups']))
            @foreach($endpoints['groups'] as $groupId => $group)
                <!-- Group Header -->
                <div id="group-{{ $groupId }}" class="mb-8">
                    <div class="border-l-4 border-blue-500 pl-6 mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $group['name'] }}</h2>
                        <p class="text-lg text-gray-600">{{ $group['description'] ?? '' }}</p>
                    </div>

                    <!-- Endpoints in this group -->
                    @if(isset($group['endpoints']))
                        <div class="space-y-8">
                            @foreach($group['endpoints'] as $endpointId => $endpoint)
                                <div id="{{ $groupId }}-{{ $endpointId }}" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <!-- Header -->
                                    <div class="p-6 border-b bg-gray-50">
                                        <div class="flex items-center mb-4">
                                    <span class="method-badge method-{{ strtolower($endpoint['method']) }} mr-3 text-sm font-bold">
                                        {{ $endpoint['method'] }}
                                    </span>
                                            <code class="text-lg font-mono text-gray-800 bg-gray-100 px-3 py-1 rounded">{{ $endpoint['path'] }}</code>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $endpoint['title'] }}</h3>
                                        <p class="text-gray-600">{{ $endpoint['description'] }}</p>

                                        <div class="flex items-center gap-4 mt-4">
                                            @if(isset($endpoint['auth_required']) && $endpoint['auth_required'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        🔒 Auth Required
                                    </span>
                                            @endif
                                            @if(isset($endpoint['rate_limit']))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⚡ {{ $endpoint['rate_limit'] }}
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6" x-data="{ activeTab: 'request' }">
                                        <!-- Tabs -->
                                        <div class="border-b border-gray-200 mb-6">
                                            <nav class="flex space-x-8">
                                                @if(isset($endpoint['request']))
                                                    <button @click="activeTab = 'request'"
                                                            :class="activeTab === 'request' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm hover:text-gray-700 transition-colors">
                                                        Request
                                                    </button>
                                                @endif
                                                @if(isset($endpoint['responses']))
                                                    <button @click="activeTab = 'responses'"
                                                            :class="activeTab === 'responses' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm hover:text-gray-700 transition-colors">
                                                        Responses
                                                    </button>
                                                @endif
                                                @if(isset($endpoint['examples']))
                                                    <button @click="activeTab = 'examples'"
                                                            :class="activeTab === 'examples' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm hover:text-gray-700 transition-colors">
                                                        Examples
                                                    </button>
                                                @endif
                                            </nav>
                                        </div>

                                        <!-- Request Tab -->
                                        @if(isset($endpoint['request']))
                                            <div x-show="activeTab === 'request'" x-transition>
                                                @if(isset($endpoint['request']['headers']))
                                                    <h4 class="font-semibold text-gray-900 mb-3">Headers</h4>
                                                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                                        @foreach($endpoint['request']['headers'] as $header => $value)
                                                            <div class="mb-2 last:mb-0 font-mono text-sm">
                                                                <span class="text-blue-600">{{ $header }}:</span>
                                                                <span class="text-gray-700">{{ $value }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(isset($endpoint['request']['body']))
                                                    <h4 class="font-semibold text-gray-900 mb-3">Request Body</h4>
                                                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                                        @foreach($endpoint['request']['body'] as $field => $details)
                                                            <div class="mb-4 last:mb-0 p-3 bg-white rounded border">
                                                                <div class="flex items-center gap-2 mb-1">
                                                                    <code class="text-blue-600 font-mono font-medium">{{ $field }}</code>
                                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $details['type'] }}</span>
                                                                    @if($details['required'])
                                                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded font-medium">required</span>
                                                                    @endif
                                                                </div>
                                                                <p class="text-sm text-gray-600 mb-2">{{ $details['description'] }}</p>
                                                                <div class="text-xs text-gray-500">
                                                                    <strong>Example:</strong>
                                                                    <code class="bg-gray-100 px-1 py-0.5 rounded">{{ $details['example'] }}</code>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Responses Tab -->
                                        @if(isset($endpoint['responses']))
                                            <div x-show="activeTab === 'responses'" x-transition>
                                                @foreach($endpoint['responses'] as $code => $response)
                                                    <div class="mb-6 last:mb-0">
                                                        <div class="flex items-center gap-2 mb-3">
                                                            <span class="status-badge status-{{ $code }} font-bold">{{ $code }}</span>
                                                            <span class="text-gray-600 font-medium">{{ $response['description'] }}</span>
                                                        </div>
                                                        <div class="bg-gray-900 rounded-lg overflow-hidden">
                                                            <div class="flex items-center justify-between px-4 py-2 bg-gray-800">
                                                                <span class="text-gray-300 text-sm font-medium">Response</span>
                                                                <button onclick="copyToClipboard(this)" class="text-gray-400 hover:text-white text-xs">
                                                                    Copy
                                                                </button>
                                                            </div>
                                                            <pre class="p-4 text-gray-100 overflow-x-auto text-sm"><code class="language-json">{{ json_encode($response['example'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Examples Tab -->
                                        @if(isset($endpoint['examples']))
                                            <div x-show="activeTab === 'examples'" x-transition>
                                                @foreach($endpoint['examples'] as $lang => $example)
                                                    <div class="mb-6 last:mb-0">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h5 class="font-medium text-gray-900 capitalize">{{ $lang === 'curl' ? 'cURL' : ucfirst($lang) }}</h5>
                                                            <button onclick="copyToClipboard(this)" class="text-gray-500 hover:text-gray-700 text-xs">
                                                                Copy
                                                            </button>
                                                        </div>
                                                        <div class="bg-gray-900 rounded-lg overflow-hidden">
                                                            <pre class="p-4 text-gray-100 overflow-x-auto text-sm"><code class="language-{{ $lang === 'curl' ? 'bash' : $lang }}">{{ $example }}</code></pre>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    .method-badge {
        @apply px-2 py-1 text-xs rounded uppercase;
    }
    .method-get { @apply bg-blue-100 text-blue-800; }
    .method-post { @apply bg-green-100 text-green-800; }
    .method-put { @apply bg-yellow-100 text-yellow-800; }
    .method-delete { @apply bg-red-100 text-red-800; }
    .method-patch { @apply bg-purple-100 text-purple-800; }

    .status-badge {
        @apply px-2 py-1 text-xs rounded font-bold;
    }
    .status-200, .status-201 { @apply bg-green-100 text-green-800; }
    .status-400, .status-401, .status-403, .status-404 { @apply bg-red-100 text-red-800; }
    .status-422 { @apply bg-yellow-100 text-yellow-800; }
    .status-500 { @apply bg-gray-100 text-gray-800; }

    /* Улучшенная подсветка активных ссылок */
    nav a.active {
        @apply bg-blue-50 text-blue-700 border-r-2 border-blue-500;
    }

    /* Плавные переходы для групп */
    .group-header {
        scroll-margin-top: 2rem;
    }

    /* Стили для улучшения читаемости кода */
    pre code {
        font-family: 'Fira Code', 'Monaco', 'Consolas', monospace;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Улучшенные отступы между группами */
    .group-separator {
        border-top: 2px solid #e5e7eb;
        margin: 3rem 0;
        position: relative;
    }

    .group-separator::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    }

    /* Анимация для появления элементов */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Улучшенный hover эффект для методов */
    .method-badge:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }

    /* Индикатор прогресса чтения */
    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        z-index: 1000;
        transition: width 0.1s ease-out;
    }

    /* Улучшенный скролл для sidebar */
    .sidebar-nav {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    function apiDocs() {
        return {
            activeEndpoint: '',
            activeGroup: '',
            init() {
                // Подсветка активного раздела при скролле
                this.setupScrollSpy();
                // Плавный скролл для ссылок
                this.setupSmoothScrolling();
            },
            setupScrollSpy() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Обновляем активный endpoint
                            if (entry.target.id.includes('-') && !entry.target.id.startsWith('group-')) {
                                this.activeEndpoint = entry.target.id;
                                this.updateActiveLink(entry.target.id);
                            }

                            // Обновляем активную группу
                            if (entry.target.id.startsWith('group-')) {
                                this.activeGroup = entry.target.id;
                            }
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '-100px 0px -50% 0px'
                });

                // Наблюдаем за группами и endpoints
                document.querySelectorAll('[id^="group-"], [id*="-"]:not([id^="group-"])').forEach(el => {
                    observer.observe(el);
                });
            },
            setupSmoothScrolling() {
                document.querySelectorAll('nav a[href^="#"]').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetId = link.getAttribute('href').substring(1);
                        const target = document.getElementById(targetId);
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                            this.activeEndpoint = targetId;
                            this.updateActiveLink(targetId);
                        }
                    });
                });
            },
            updateActiveLink(targetId) {
                // Убираем активное состояние со всех ссылок
                document.querySelectorAll('nav a').forEach(link => {
                    link.classList.remove('bg-blue-50', 'text-blue-700', 'border-r-2', 'border-blue-500');
                    link.classList.add('text-gray-600');
                });

                // Добавляем активное состояние к текущей ссылке
                const activeLink = document.querySelector(`nav a[href="#${targetId}"]`);
                if (activeLink) {
                    activeLink.classList.add('bg-blue-50', 'text-blue-700', 'border-r-2', 'border-blue-500');
                    activeLink.classList.remove('text-gray-600');

                    // Скроллим сайдбар к активной ссылке если нужно
                    activeLink.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }
            }
        }
    }

    function copyToClipboard(button) {
        const codeBlock = button.closest('.bg-gray-900').querySelector('code');
        const text = codeBlock.textContent;

        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('text-green-400');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('text-green-400');
            }, 2000);
        }).catch(() => {
            // Fallback для старых браузеров
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);

            const originalText = button.textContent;
            button.textContent = 'Copied!';
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        });
    }

    // Автоматическое обновление времени сессии каждые 5 минут
    setInterval(() => {
        fetch(window.location.href, { method: 'HEAD' })
            .catch(() => {
                // Если сессия истекла, перенаправляем на страницу входа
                window.location.href = '{{ route("docs.login") }}';
            });
    }, 300000);

    // Улучшенная подсветка синтаксиса при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Prism !== 'undefined') {
            Prism.highlightAll();
        }
    });

    // Добавляем поддержку клавиатурной навигации
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K для фокуса на поиске (если добавите)
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            // Здесь можно добавить фокус на поле поиска
        }

        // Escape для закрытия модальных окон
        if (e.key === 'Escape') {
            // Закрываем любые открытые модальные окна
        }
    });
</script>
</body>
</html>
