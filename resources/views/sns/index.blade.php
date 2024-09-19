<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- ↓編集ここから↓ -->
            投稿一覧
            <!-- ↑編集ここまで↑ -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ↓編集ここから↓ -->
                    <!-- セッションにメッセージが保存されている時用 -->
                    @if(session('message'))
                        <p>{{ session('message') }}</p>
                    @endif

                    <!-- ↓テンプレート↓ -->
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                @foreach($posts as $post)
                                    @php
                                        $imageUrl=asset('storage/images/'.$post->post_blob);
                                    @endphp
                                    <div class="p-4 lg:w-1/3">
                                    @if( !is_null($post->post_blob) )
                                        <div class="w-full h-full bg-cover px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative" style="background-image:url('{{asset('storage/images/'.$post->post_blob)}}')">
                                    @else
                                        <div class="h-full bg-gray-500 bg-opacity-50 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative">
                                    @endif

                                            <div class="absolute top-2 right-2">
                                                <span class="bg-white inline-block">
                                                    user:
                                                    <a href="{{ route('sns.userpage',$post->user->id) }}" class="hover:text-blue-300 text-blue-600 font-bold underline">
                                                        {{ $post->user->name }}
                                                    </a>
                                                </span>
                                            </div>
                                        
                                            <p class="leading-relaxed mb-3 opacity-80">
                                                <span class="bg-white">
                                                    投稿文：
                                                    @if( !is_null($post->post_text) )
                                                    {{ $post->post_text }}
                                                    @endif
                                                </span>
                                            </p>

                                        <div class="bg-white inline-block">
                                            <a href="{{ route('sns.show',$post) }}" class="hover:text-blue-300 text-blue-600 font-bold underline">
                                                詳細はこちら
                                            </a>
                                        </div>
                                        
                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <!-- ↑テンプレート↑ -->
                    
                    <!-- ↑編集ここまで↑ -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>