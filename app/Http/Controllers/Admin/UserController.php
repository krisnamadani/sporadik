<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function data(Request $request)
    {
        if($request->ajax()) {
            $user = User::select('*')->latest('id');

            return DataTables::of($user)
                ->addIndexColumn()
                ->editColumn('avatar', function($row) {
                    if($row->avatar == null) {
                        return '<img height="80" width="80" src="' . asset('sporadik/img/user-icon.webp') . '">';
                    }

                    return '<img height="80" width="80" src="' . Storage::url($row->avatar) . '">';
                })
                ->addColumn('action', function($row) {
                    if($row->id == Auth::user()->id || Auth::user()->id == 1) {
                        return '<button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown">
                            <i class="nav-icon fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="#" onClick="edit('.$row->id.')">Edit</a>
                            <a class="dropdown-item" href="#" onClick="remove('.$row->id.')">Hapus</a>
                        </div>';
                    }

                    return '';
                    
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            if($request->has('avatar')) {
                $avatar = $request->file('avatar');
                $avatar_name = Str::slug($validated['name']);
                $avatar_path = 'public/user/avatar/'.$avatar_name.'.webp';
                $avatar_conversion = Image::make($avatar)->encode('webp');
                
                Storage::put($avatar_path, $avatar_conversion);

                $validated['avatar'] = $avatar_path;
            }

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);
            DB::commit();

            return $this->response(true, 'Berhasil menambah user');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        return response()->json(User::findOrFail($request->id));
    }

    public function update(UserRequest $request)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();

        try {
            $user = User::findOrFail($request->id);

            if($request->id == 1 && Auth::user()->id != 1) {
                throw new Exception('Kamu tidak dapat mengubah user ini', 422);
            }
            
            if($request->has('avatar')) {
                if($user->avatar != null) {
                    Storage::delete($user->avatar);
                }
                
                $avatar = $request->file('avatar');
                $avatar_name = Str::slug($validated['name']);
                $avatar_path = 'public/user/avatar/'.$avatar_name.'.webp';
                $avatar_conversion = Image::make($avatar)->encode('webp');
                
                Storage::put($avatar_path, $avatar_conversion);

                $validated['avatar'] = $avatar_path;
            }

            if($request->has('password')) {
                $validated['password'] = Hash::make($validated['password']);
            }

            
            $user->update($validated);

            DB::commit();

            return $this->response(true, 'Berhasil mengubah user');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            if($request->id == 1) {
                throw new Exception('User ini tidak dapat dihapus', 422);
            }

            $user = User::findOrFail($request->id);
            $user->delete();

            DB::commit();
            
            if($user->avatar != null) {
                Storage::delete($user->avatar);
            }

            return $this->response(true, 'Berhasil menghapus user');
        } catch (QueryException $e) {
            DB::rollback();

            return $this->response(false, 'Gagal menghapus user, user memiliki data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }
}
