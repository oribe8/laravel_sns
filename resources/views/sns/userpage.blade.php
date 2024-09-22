<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- ↓編集ここから↓ -->
            ユーザーページ
            <!-- ↑編集ここまで↑ -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ↓編集ここから↓ -->
                    <!-- ↓テンプレート1↓ -->
                    <section class="text-gray-600 body-font">
                        <div class="container mx-auto flex px-5 py-5 md:flex-row flex-col items-center">
                            <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                                <h2 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                                    {{ $user->name }}
                                </h2>
                                <p class="mb-8 leading-relaxed">
                                    <!-- プロフィール文表示 -->
                                    <p>プロフィール文：
                                    @if( !is_null($user->profile_text) )
                                        {{ $user->profile_text }}
                                    @endif
                                    </p>
                                </p>
                                <!-- ログインユーザー向け -->
                                @auth
                                    <div class="flex justify-center mt-5">
                                    <!-- フォローボタン、フォロー解除ボタン表示 -->
                                    @can('follow_button',$user)
                                        @can('unfollow_button',$user)
                                            <!-- フォロー解除ボタン表示 -->
                                            <form method="post" action="{{ route('sns.unfollow',$user) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">フォロー解除</button>
                                            </form>
                                        @else
                                            <!-- フォローボタン表示 -->
                                            <form method="post" action="{{ route('sns.follow',$user) }}">
                                                @csrf
                                                <button class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">フォロー</button>
                                            </form>
                                        @endcan
                                    @endcan
                                    </div>
                                @endauth
                            </div>
                            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                                @if( !is_null($user->profile_image) )
                                <img class="h-52 object-cover object-center rounded mx-auto my-0" alt="" src="{{ asset('storage/images/'.$user->profile_image) }}">
                                @else
                                <img class="h-52 object-cover object-center rounded mx-auto my-0" alt="" src="{{ asset('storage/images/no_image_icon.png') }}">
                                @endif
                            </div>
                        </div>
                    </section>
                    <!-- ↑テンプレート1↑ -->

                    <!-- ユーザーの投稿表示 -->
                    <!-- ↓テンプレート2↓ -->
                    <section class="text-gray-600 body-font">
                        <h3 class="title-font sm:text-2xl text-2xl mt-8 mb-4 font-medium text-gray-900 text-center md:text-justify md:ml-4">
                            {{ $user->name }}の投稿一覧
                        </h3>
                        <div class="container px-5 py-5 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                @foreach($posts as $post)
                                    <div class="p-4 w-full md:w-1/3">
                                    <!-- 投稿で画像があるかないかでタグを出し分け -->
                                    @if( !is_null($post->post_blob) )
                                        <div class="h-full bg-cover bg-center px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative" style="background-image:url({{asset('storage/images/'.$post->post_blob)}})">
                                    @else
                                        <div class="h-full bg-cover bg-center px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative" style="background-image:url({{asset('storage/images/no_image_icon.png')}})">
                                    @endif

                                            <div class="absolute top-2 right-2">
                                                <span class="bg-white inline-block">
                                                    user:
                                                    <a href="{{ route('sns.userpage',$post->user->id) }}" class="hover:text-blue-300 text-blue-600 font-bold underline">
                                                        {{ $post->user->name }}
                                                    </a>
                                                </span>
                                            </div>
                                        
                                            <!-- 投稿文表示 -->
                                            <p class="leading-relaxed mb-3 opacity-80">
                                                <span class="bg-white">
                                                    投稿文：
                                                    @if( !is_null($post->post_text) )
                                                        {{ $post->post_text }}
                                                    @else
                                                        無し
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
                    <!-- ↑テンプレート2↑ -->

                    <!-- ↑編集ここまで↑ -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>