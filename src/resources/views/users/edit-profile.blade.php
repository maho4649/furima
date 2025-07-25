@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6"  style="max-width: 600px;">
<h2>プロフィール設定</h2>
<form action="{{route('profile.update') }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

 <div style="display: flex; align-items: center; gap: 50px; margin-bottom: 24px;">
    @if($user->left_icon)
        <img id="preview"src="{{ asset('storage/' . $user->left_icon) }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;"  alt="">
        @else
        <img id="preview" src="" 
         style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;" 
         alt="">
    @endif
    <label class="btn-upload">
      画像を選択する
      <input type="file" id="icon-input" name="left_icon" accept="image/*" style="display: none;">
    </label>
     @if ($errors->has('left_icon'))
      <p style="color: red; font-size: 14px;">{{$errors->first('left_icon')}}</p>
     @endif

    </div>

    <label class="form-label">ユーザー名</label>
    <input type="text" name="name"  style="w-full border rounded p-2" value="{{ old('name', $user->name) }}" >
    @if ($errors->has('name'))
      <p style="color: red;">{{ $errors->first('name') }}</p>
    @endif

    <label class="form-label">郵便番号</label>
    <input type="text" name="zipcode" style="w-full border rounded p-2"value="{{ old('zipcode', auth()->user()->zipcode) }}">
    @if ($errors->has('zipcode'))
      <p style="color: red;">{{ $errors->first('zipcode') }}</p>
    @endif

    <label class="form-label">住所</label>
    <input type="text" name="address" style="w-full border rounded p-2"value="{{ old('address', auth()->user()->address) }}">
    @if ($errors->has('address'))
      <p style="color: red;">{{ $errors->first('address') }}</p>
    @endif

    <label class="form-label">建物名</label>
    <input type="text" name="building"style="w-full border rounded p-2" value="{{ old('building', auth()->user()->building) }}">
    @if ($errors->has('building'))
      <p style="color: red;">{{ $errors->first('building') }}</p>
    @endif

    <button type="submit" class="submit-btn">保存</button>
   </form>
  </div>
  

<!-- JS（プレビュー表示） -->
<script>
  document.getElementById('icon-input').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const preview = document.getElementById('preview');
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  });
</script>

@endsection


