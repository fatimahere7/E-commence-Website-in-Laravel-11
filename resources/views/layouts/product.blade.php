@extends('layouts.admin')
@section('title')
    Admin | Add Product
@endsection


@section('content')
<br><br>
<style>
    html * {
     box-sizing: border-box;
    }
    
    p {
       margin: 0;
    }
    
    .upload__box {
        padding-top:30px; 
       padding-bottom: 40px;
     
    }
    .upload__btn-box {
    margin-bottom: 20px; /* Add space between the button and images */
}
    
    .upload__inputfile {
       width: .1px;
       height: .1px;
       opacity: 0;
       overflow: hidden;
       position: absolute;
       z-index: -1;
    }
    
    .upload__btn {
       display: inline-block;
       font-weight: 600;
       color: #090909;
       text-align: center;
       min-width: 116px;
       padding: 5px;
       transition: all .3s ease;
       cursor: pointer;
       border: 2px solid;
       background-color: #40acba;
       border-color: #40aaba;
       border-radius: 10px;
       line-height: 26px;
       font-size: 14px;
    }
    
    .upload__btn:hover {
       background-color: unset;
       color: #4045ba;
       transition: all .3s ease;
    }
    
    .upload__img-wrap {
       display: flex;
       flex-wrap: wrap;
       margin: 0 -10px;
    }
    
    .upload__img-box {
       width: 200px;
       padding: 0 10px;
       margin-bottom: 12px;
    }
    
    .upload__img-close {
       width: 24px;
       height: 24px;
       border-radius: 50%;
       background-color: rgba(0, 0, 0, 0.5);
       position: absolute;
       top: 10px;
       right: 10px;
       text-align: center;
       line-height: 24px;
       z-index: 1;
       cursor: pointer;
    }
    
    .upload__img-close:after {
       content: '\2716';
       font-size: 14px;
       color: white;
    }
    
    .img-bg {
       background-repeat: no-repeat;
       background-position: center;
       background-size: cover;
       position: relative;
       padding-bottom: 100%;
    }

</style>
<div class="container">
    <h1 class="text-center mb-4">Add Product</h1> 
    
    <div class="card">
        <div class="card-body">
           
            <form action="{{  route('admin.uploadProduct') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('message'))
                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                       {{ Session::get('message') }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>  
                @endif
                <!-- Product Title -->
                 <div class="mb-3">
                   <label for="title" class="form-label fw-bold">Product Title</label>
                   <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                 </div>
                 
                 <!-- Description -->
                 <div class="mb-3">
                   <label for="description" class="form-label fw-bold">Description</label>
                   <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                 </div>
                 
                 <!-- Price -->
                 <div class="mb-3">
                   <label for="price" class="form-label fw-bold">Price</label>
                   <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                 </div>
                 
                 <!-- Quantity -->
                 <div class="mb-3">
                   <label for="quantity" class="form-label fw-bold">Quantity</label>
                   <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                 </div>
                 
                 <!-- Product Category -->
                 <div class="mb-3">
                   <label for="category" class="form-label fw-bold">Product Category</label>
                   <select class="form-select" id="category" name="category" required>
                       <option value="">Select a category</option>
                       @foreach($categories as $category)
                           <option value="{{ $category->category_name }}" {{ old('category') == $category->category_name ? 'selected' : '' }}>
                               {{ $category->category_name }}
                           </option>
                       @endforeach
                   </select>
                 </div>
                 
                 <!-- Image Upload Section -->
                 <div class="mb-3">
                   <label class="form-label" for="inputImage">Select Images:</label>
                   <input 
                       type="file" 
                       name="images[]" 
                       id="inputImage"
                       multiple 
                       class="form-control @error('images') is-invalid @enderror">
                     
                   @error('images')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
                 </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Add Product</button>
            </form>
        </div>
    </div>
</div>
   


@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function () {
      ImgUpload();
    });
    
    function ImgUpload() {
      var imgWrap = "";
      var imgArray = [];
    
      $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
          imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
          var maxLength = $(this).attr('data-max_length');
    
          var files = e.target.files;
          var filesArr = Array.prototype.slice.call(files);
          var iterator = 0;
          filesArr.forEach(function (f, index) {
    
            if (!f.type.match('image.*')) {
              return;
            }
    
            if (imgArray.length > maxLength) {
              return false
            } else {
              var len = 0;
              for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                  len++;
                }
              }
              if (len > maxLength) {
                return false;
              } else {
                imgArray.push(f);
    
                var reader = new FileReader();
                reader.onload = function (e) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
                }
                reader.readAsDataURL(f);
              }
            }
          });
        });
      });
    
      $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
          if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
          }
        }
        $(this).parent().parent().remove();
      });
    }
</script>
@endsection