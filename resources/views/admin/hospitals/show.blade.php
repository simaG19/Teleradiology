<x-app-layout>
  <x-slot name="header">
    <h2>Hospital: {{ $user->name }}</h2>
  </x-slot>

  <div class="p-6 bg-white shadow rounded">
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Monthly File Limit:</strong> {{ $profile->monthly_file_limit ?: 'Unlimited' }}</p>
    <p><strong>Uploader Accounts Limit:</strong> {{ $profile->uploader_account_limit ?: 'Unlimited' }}</p>
    <p><strong>Billing Rate:</strong> ${{ number_format($profile->billing_rate,2) }} per file</p>
    <!-- any other profile fields -->
  </div>
</x-app-layout>
