  <x-layout>
                <x-card class="p-10">
                    <header>
                        <h1
                            class="text-3xl text-center font-bold my-6 uppercase"
                        >
                            Manage Gigs
                        </h1>
                    </header>

                    <table class="w-full table-auto rounded-sm">
                        <tbody>

                            @unless (count($listings) == 0)
                            @foreach ($listings as $listing)
                                
                            <tr class="border-gray-300">
                                <td
                                class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                                >
                                <a href="/listings/{listing}">
                                    {{ $listing->title}}
                                </a>
                            </td>
                            <td
                            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                            >
                                    <a
                                    href="/listings/{{$listing->id}}/edit"
                                        class="text-blue-400 px-6 py-2 rounded-xl"
                                        ><i
                                        class="fa-solid fa-pen-to-square"
                                        ></i>
                                        Edit</a
                                        >
                                    </td>
                                    <td
                                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                                    >
                                    <form action="/listings/{{$listing->id}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            class="text-red-500"> 
                                            <i class="fa-solid fa-trash"></i> 
                                            DELETE 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach    
                            
                            @else
                             <td
                                class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                                >
                            <p>No Listing Found</p>
                             </td>
                        </tbody>
                        @endunless
                    </table>


                </x-card>
            </x-layout>