@extends('layouts.admin')

@section('title')
    Admin | Dashboard
@endsection

@section('content')
   <div  style="padding: 50px">
      <div class="admin-dashboard">
          <h1>Welcome, {{ Auth::user()->name }}!</h1>
          <div class="admin-profile">
              <h3>Admin Profile</h3>
              <ul>
                  <li><strong>Name:</strong> {{ Auth::user()->name }}</li>
                  <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                 
              </ul>

          </div>
          <br><br><br>
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

      <!-- Success message -->
      @if (Session::has('message'))
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
             {{ Session::get('message') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>  
      @endif
          <h3>Your Product Orders</h3>
           <table class="table">
               <thead>
                   <tr>
                       <th>Order ID</th>
                       <th>Product</th>
                       <th>Quantity</th>
                       <th>Total Price</th>
                       <th>Ordered By</th>
                       <th>Status</th>
                   </tr>
               </thead>
               <tbody>
                   @if($orderItems->isEmpty())
                       <tr>
                           <td colspan="6" class="text-center">No orders found.</td>
                       </tr>
                   @else
                       @foreach($orderItems as $item)
                           <tr>
                               <td>{{ $item->order->id }}</td>
                               <td>{{ $item->product->title }}</td>
                               <td>{{ $item->quantity }}</td>
                               <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                               <td>{{ $item->order->user->name }}</td>
                               <td>
                                <form action="{{ route('admin.updateOrderStatus', $item->order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Dropdown to select status -->
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $item->order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $item->order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $item->order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $item->order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $item->order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                 </td>
     
                                 <!-- Submit button to change status -->
                                 <td>
                                     <button type="submit" class="btn btn-primary">Update Status</button>
                                </form>
                                 </td>
                           </tr>
                       @endforeach
                   @endif
               </tbody>
           </table>
             <!-- Pagination links -->
             {{-- <div class="d-flex justify-content-center">
                {{ $orderItems->links() }}
            </div> --}}
      </div>
    </div> 
    
   

{{-- @if($orders->count() > 0) --}}
       
@endsection