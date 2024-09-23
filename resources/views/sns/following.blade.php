<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- ↓編集ここから↓ -->
            フォロー中の投稿一覧
            <!-- ↑編集ここまで↑ -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ↓編集ここから↓ -->
                    <!-- セッションにメッセージが保存されている場合は出力させる -->
                    @if(session('message'))
                        <p>{{ session('message') }}</p>
                    @endif

                    <!-- ↓テンプレート↓ -->
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-5 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                @foreach($posts as $post)
                                    <!-- 全投稿（テキスト、画像）を出力していく -->
                                    <div class="p-4 w-full md:w-1/3">
                                    <!-- 投稿で画像があるかないかでタグを出し分け -->
                                    @if( !is_null($post->post_blob) )
                                        <!-- 各投稿に保存されている画像を背景として出力 -->
                                        <div class="h-full bg-cover bg-center px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative" style="background-image:url({{asset('storage/images/'.$post->post_blob)}})">
                                    @else
                                        <!-- noimage画像を背景として出力 -->
                                        <div class="h-full bg-cover bg-center px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative" style="background-image:url({{asset('storage/images/no_image_icon.png')}})">
                                    @endif

                                            <!-- 「投稿者名」「投稿者ページへのリンク」を出力 -->
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
                                                    <!-- 投稿にテキストがあるかないかで内容出し分け -->
                                                    投稿文：
                                                    @if( !is_null($post->post_text) )
                                                        {{ $post->post_text }}
                                                    @else
                                                        無し
                                                    @endif
                                                </span>
                                            </p>

                                        <div class="bg-white inline-block">
                                            <!-- 各投稿の詳細ページへのリンク -->
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