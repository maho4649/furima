@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6" style="max-width: 600px;">
    <h2 class="text-2xl font-bold mb-4">商品の出品</h2>

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div class="mb-4">
            <label class="image">商品画像</label>
              <div class="image-upload-box" style="text-align: center;">
            <label for="image" class="custom-file-label">画像を選択する</label>
            <input id="image" class="custom-file-input" type="file" name="image" accept="image/*" >
            @error('image')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <img id="image-preview" class="preview-img" src="" alt="画像プレビュー" style="display:none; max-width: 100%; margin-top: 10px; border-radius: 4px;">
          </div>
        </div>

        <h3>商品の詳細</h3>
        <div style=" border-bottom: 2px solid #ccc;margin-bottom: 2.5rem; margin-top: 2rem padding-bottom: 0.5rem;"></div>

        <!-- カテゴリ（複数選択） -->
        <div class="mb-4">
          <label class="block font-semibold mb-2">カテゴリー</label>
          <div id="category-buttons" class="flex flex-wrap gap-2">
           @foreach($categories as $category)
            <button type="button"
                    class="category-btn"
                    data-category-id="{{ $category->id }}"
                    data-category-name="{{ $category->name }}">
                {{ $category->name }}
            </button>
            @endforeach
           </div>
        </div>
        <!-- 選択したカテゴリーを送信するための hidden input -->
        <div id="selected-categories"></div>
        @error('categories')
         <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror


       </br>
        <!-- 商品の状態 -->
        <div class="mb-4">
            <label class="block font-semibold">商品の状態</label>
            <select name="condition" >
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            @error('condition')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        </br>
        <h3>商品名と説明</h3>
        <div style=" border-bottom: 2px solid #ccc;margin-bottom: 2.5rem; margin-top: 2rem padding-bottom: 0.5rem;"></div>

        <!-- 商品名 -->
        <div class="mb-4">
            <label class="block font-semibold">商品名</label>
            <input type="text" name="name" class="w-full " >
            @error('name')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ブランド名 -->
        <div class="mb-4">
            <label class="block font-semibold">ブランド名</label>
            <input type="text" name="brand" class="w-full">
        </div>

        <!-- 商品説明 -->
        <div class="mb-4">
            <label class="block font-semibold">説明</label>
            <textarea name="description"  class="w-full" rows="4"></textarea>
            @error('description')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 販売価格 -->
        <div class="mb-4">
            <label class="block font-semibold">販売価格</label>
            <div class="price-box w-full">
             <span class="yen">¥</span>
             <input type="number" name="price" >
             @error('price')
               <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
             @enderror
            </div>
        </div>

        <!-- 出品ボタン -->
        <div style="margin-bottom:80px;">
            <button type="submit" class="submit-btn">出品する</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.category-btn');
    const selectedContainer = document.getElementById('selected-categories');
    const selectedCategories = new Set();

    // 初期状態で selected クラスが付いたボタンのカテゴリIDをセット
    buttons.forEach(button => {
        if (button.classList.contains('selected')) {
            selectedCategories.add(button.dataset.categoryId);
        }
    });

    // hidden input 初期化
    updateHiddenInputs();

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const categoryId = button.dataset.categoryId;

            if (selectedCategories.has(categoryId)) {
                selectedCategories.delete(categoryId);
                button.classList.remove('selected');
            } else {
                selectedCategories.add(categoryId);
                button.classList.add('selected');
            }

            updateHiddenInputs();
        });
    });

    // hidden inputを更新する関数
    function updateHiddenInputs() {
        selectedContainer.innerHTML = '';
        selectedCategories.forEach(catId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'categories[]';
            input.value = catId;
            selectedContainer.appendChild(input);
        });
    }
});


</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // カテゴリボタンのスクリプトはそのまま

    // 画像プレビュー処理
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
});
</script>
@endsection


