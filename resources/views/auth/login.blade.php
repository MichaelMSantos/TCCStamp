<x-guest-layout>
    <main class="flex h-screen antialiased">
        <form action="{{ route('login') }}" method="POST"
            class="flex flex-col p-10 bg-white sm:w-1/4 desktop:w-1/2 w-full tablet:p-5"
            style="box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);">
            @csrf
            <section class="flex justify-center mb-20">
                <img src="{{ asset('/images/logo.png') }}" alt="" class="desktop:w-[150px] tablet:w-2/5">
            </section>
            <div class="w-full">
                <div class="flex flex-col mb-2">
                    <label>Email</label>
                    <div class="flex items-center mb-4">
                        <input type="email" name="email" id="email" class="rounded-l-md w-full p-2 h-9"
                            style="border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); background-color: #f2f4f7">
                        <span class="flex justify-center items-center rounded-r-md h-9 bg-[#2f515f] w-12"
                            style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <img src="{{ asset('/images/email.svg') }}" alt="" class="h-[22px]">
                        </span>
                    </div>
                </div>
                <div class="flex flex-col mb-8">
                    <label>Senha</label>
                    <div class="flex items-center">
                        <input type="password" name="password" id="password" class="rounded-l-md w-full p-2 h-9"
                            style="border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); background-color: #f2f4f7">
                        <span class="flex justify-center items-center shadow-md rounded-r-md h-9 bg-[#2f515f] w-12"
                            style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <img src="{{ asset('/images/lock.svg') }}" alt="" class="h-[22px]">
                        </span>
                    </div>
                    <div class="flex justify-between text-sm mt-2">
                        <div class="flex items-center gap-1">
                            <input type="checkbox" onclick="togglePassword()" class="h-4 w-4">
                            <span>Mostrar senha</span>
                        </div>
                        <p id="caps" class="text-red-500 font-semibold hidden">Capslock ativado</p>
                    </div>
                </div>

                <button type="submit"
                    class="shadow-md rounded-md w-full bg-[#2f515f] text-white h-10 mt-5 transition-opacity duration-300 hover:opacity-80">
                    Entrar
                </button>
            </div>
            <div class="mt-2">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>

        <aside class="justify-center items-center w-3/4 hidden sm:flex"
            style="background-color: #e5e7eb; z-index: -1;">
            <img src="{{ asset('/images/login-illustrator.svg') }}" alt="" class="desktop:w-2/3">
        </aside>
    </main>
</x-guest-layout>
