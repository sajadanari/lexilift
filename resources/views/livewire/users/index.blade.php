<div class="mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Users</h1>
        <x-forms.primary-btn
            wire:click="showCreatePage"
            icon="add"
        >
            Add New User
        </x-forms.primary-btn>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif


    <table class="table-auto w-full mb-6 border-collapse">
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
