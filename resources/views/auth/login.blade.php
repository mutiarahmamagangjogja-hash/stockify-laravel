<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login - Stockify
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="min-h-screen bg-[#111827]">

    <div class="flex min-h-screen items-center justify-center px-4">

        <div class="w-full max-w-md">

            {{-- LOGO / BRAND --}}
            <div class="mb-8 text-center">

                <h1 class="text-3xl font-bold text-white">
                    Stockify
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Sistem Manajemen Persediaan
                </p>

            </div>


            {{-- LOGIN CARD --}}
            <div
                class="rounded-2xl
                       border border-slate-700
                       bg-slate-900
                       p-8
                       shadow-2xl"
            >

                <div class="mb-6">

                    <h2 class="text-xl font-bold text-white">
                        Login
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Masuk ke akun Stockify Anda.
                    </p>

                </div>


                {{-- ERROR --}}
                @if($errors->any())

                    <div
                        class="mb-5
                               rounded-xl
                               border border-red-500/30
                               bg-red-500/10
                               p-4"
                    >

                        @foreach($errors->all() as $error)

                            <p class="text-sm text-red-300">
                                {{ $error }}
                            </p>

                        @endforeach

                    </div>

                @endif


                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                    class="space-y-5"
                >

                    @csrf


                    {{-- EMAIL --}}
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-medium text-slate-300"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Masukkan email"
                            class="w-full
                                   rounded-xl
                                   border border-slate-700
                                   bg-slate-800
                                   px-4 py-3
                                   text-sm text-white
                                   outline-none
                                   transition
                                   placeholder:text-slate-600
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20"
                        >

                    </div>


                    {{-- PASSWORD --}}
                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-medium text-slate-300"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            class="w-full
                                   rounded-xl
                                   border border-slate-700
                                   bg-slate-800
                                   px-4 py-3
                                   text-sm text-white
                                   outline-none
                                   transition
                                   placeholder:text-slate-600
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20"
                        >

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="w-full
                               rounded-xl
                               bg-blue-600
                               px-5 py-3
                               text-sm
                               font-semibold
                               text-white
                               transition
                               hover:bg-blue-500"
                    >
                        Login
                    </button>

                </form>

            </div>


            <p class="mt-6 text-center text-xs text-slate-500">
                Stockify &copy; {{ date('Y') }}
            </p>

        </div>

    </div>

</body>

</html>