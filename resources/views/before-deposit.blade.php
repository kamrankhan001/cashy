@extends('layouts.layout')

@section('title', 'Term & Condition')

@section('main')
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500 p-4">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-screen-md w-full text-center overflow-hidden">
            <h1 class="text-3xl font-bold text-red-500 mb-4">Terms and Conditions</h1>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Welcome to Cashy</h2>
            <p class="text-center text-gray-600">To join Cashy, you have to pay a joining fee.</p>

            <h3 class="text-2xl font-bold text-blue-600 my-4">FEE: RS 800</h3>

            <div class="text-gray-700 space-y-2 text-left">
                <p class="text-xl font-bold">Cashy provides you with various online earning opportunities:</p>
                <div class="text-gray-700 space-y-2">
                    <p>&bull; Cashy offers different types of tasks for daily earning.</p>
                    <p>&bull; In Cashy, you can earn by spending time on different websites.</p>
                    <p>&bull; Cashy allows you to withdraw funds to your Easypaisa account easily.</p>
                    <p>&bull; Earn additional income by referring others to join Cashy.</p>
                    <p>&bull; Cashy has a minimum withdrawal limit of Rs.200, and no referral is required for withdrawal.
                    </p>
                </div>

            </div>

            <div class="my-4 text-start">
                <label class="">
                    <input type="checkbox" id="agreeCheckbox" class="form-checkbox h-5 w-5 text-blue-600"
                        onchange="toggleButton()">
                    <span class="ml-3 text-gray-700">I have read and agree to the terms and conditions</span>
                </label>
            </div>

            <a href="{{route('initial.deposit')}}" id="agreeButton" onclick="checkAgreement(event)"
                class="mt-3 block w-full p-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                Agree and Continue
            </a>
        </div>
    </div>

    <script>
        function checkAgreement(event) {
            const checkbox = document.getElementById('agreeCheckbox');
            if (!checkbox.checked) {
                event.preventDefault();
                alert("Please agree to the terms and conditions to continue.");
            }
        }
    </script>
@endsection
