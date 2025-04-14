<x-app-layout>
    <!-- Page Title Starts -->
  
  <x-page-title page="Usuários" header="Lista de Usuários" />

  <!-- Page Title Ends -->

    <!-- User List Starts -->
    <div class="space-y-4">
      <!-- User Header Starts -->
      <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
        <!-- User Search Starts -->
        <form method="GET" action="{{ route('users.index') }}" class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72"
        >
          <div class="flex h-full items-center px-2">
            <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
          </div>
          <input
            class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
            type="text"
            value="{{ request()->input('search') }}"
            placeholder="Search"
          />
        </form>
        <!-- User Search Ends -->

        <!-- User Action Starts -->
        <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
          <div class="flex items-center gap-x-4">
            <div class="dropdown" data-placement="bottom-end">
              <div class="dropdown-toggle">
                <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                  <i class="w-4" data-feather="filter"></i>
                  <span class="hidden sm:inline-block">Filter</span>
                  <i class="w-4" data-feather="chevron-down"></i>
                </button>
              </div>
              <div class="dropdown-content w-72 !overflow-visible">
                <ul class="dropdown-list space-y-4 p-4">
                  <li class="dropdown-list-item">
                    <h2 class="my-1 text-sm font-medium">Occupation</h2>
                    <select class="tom-select w-full" autocomplete="off">
                      <option value="">Select a Occupation</option>
                      <option value="1">Frontend Developer</option>
                      <option value="2">Full Stack Developer</option>
                      <option value="3">Web Developer</option>
                    </select>
                  </li>

                  <li class="dropdown-list-item">
                    <h2 class="my-1 text-sm font-medium">Status</h2>
                    <select class="select">
                      <option value="">Select to Status</option>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                      <option value="2">Prospect</option>
                      <option value="2">Suspended</option>
                    </select>
                  </li>
                </ul>
              </div>
            </div>
            <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
              <i class="h-4" data-feather="upload"></i>
              <span class="hidden sm:inline-block">Export</span>
            </button>
          </div>

          <a class="btn btn-primary" href="{{ route('users.create') }}" role="button">
            <i data-feather="plus" height="1rem" width="1rem"></i>
            <span class="hidden sm:inline-block">Add User</span>
          </a>
        </div>
        <!-- User Action Ends -->
      </div>
      <!-- User Header Ends -->

      <!-- User Table Starts -->
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="w-[5%]">
                <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".user-checkbox" />
              </th>
              <th class="w-[30%] uppercase">User</th>
              <th class="w-[15%] uppercase">Email</th>
              <th class="w-[15%] uppercase">Phone</th>
              <th class="w-[15%] uppercase">Joined Date</th>
              <th class="w-[15%] uppercase">Status</th>
              <th class="w-[5%] !text-right uppercase">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <input class="checkbox user-checkbox" type="checkbox" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    <img class="avatar-img" src="{{asset('images/avatar1.png')}}" alt="Avatar 1" />
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $user->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">alterar depois</p>
                  </div>
                </div>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->email }}</td>
              <td>
                <div class="badge badge-soft-success">Active</div>
              </td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <form method="POST" action="{{ route('users.destroy', $user) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                          <a href="javascript:void(0)" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="javascript:void(0)" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="trash"></i>
                            <span>Delete</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          
        </table>
      </div>
      <!-- User Table Ends -->

      <!-- User Pagination Starts -->
      <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
        <p class="text-xs font-normal text-slate-400">Showing 1 to 10 of 50 result</p>
        <!-- Pagination -->
        <nav class="pagination">
          <ul class="pagination-list">
            <li class="pagination-item">
              <a class="pagination-link pagination-link-prev-icon" href="#">
                <i data-feather="chevron-left" width="1em" height="1em"></i>
              </a>
            </li>
            <li class="pagination-item active">
              <a class="pagination-link" href="#">1</a>
            </li>
            <li class="pagination-item">
              <a class="pagination-link" href="#">2</a>
            </li>
            <li class="pagination-item">
              <a class="pagination-link" href="#">3</a>
            </li>
            <li class="pagination-item">
              <a class="pagination-link" href="#">4</a>
            </li>
            <li class="pagination-item">
              <a class="pagination-link" href="#">5</a>
            </li>
            <li class="pagination-item">
              <a class="pagination-link pagination-link-next-icon" href="#">
                <i data-feather="chevron-right" width="1em" height="1em"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- User Pagination Ends -->
    </div>
    <!-- User List Ends -->
</x-app-layout>
