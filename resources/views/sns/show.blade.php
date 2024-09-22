<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- ↓編集ここから↓ -->
            個別投稿
            <!-- ↑編集ここまで↑ -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ↓編集ここから↓ -->

                    <!-- ↓テンプレート↓ -->
                    <section class="text-gray-600 body-font">
                        <div class="container mx-auto flex px-5 py-5 items-center justify-center flex-col">
                            
                            @if( !is_null($post->post_blob) )
                            <p class="mb-3 leading-relaxed">投稿画像：</p>
                            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="" src="{{asset('storage/images/'.$post->post_blob)}}">
                            @else
                            <p class="mb-3 leading-relaxed">投稿画像：無し</p>
                            @endif

                            <div class="text-center lg:w-2/3 w-full">
                                <p class="mb-8 leading-relaxed">
                                    投稿文：
                                    @if( !is_null($post->post_text) )
                                        {{ $post->post_text }}
                                    @else
                                        無し
                                    @endif
                                </p>

                                <div class="font-bold mt-5">
                                    <span>ユーザー名：</span>
                                    <a href="{{ route('sns.userpage',$post->user->id) }}" class="hover:opacity-50 text-blue-500">{{ $post->user->name }}</a>
                                </div>

                                @can('delete_button',$post)
                                <div class="flex justify-center mt-5">
                                    <form method="post" action="{{ route('sns.destroy',$post) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">
                                            投稿の削除
                                        </button>
                                    </form>
                                </div>
                                @endcan
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