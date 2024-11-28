<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;
use App\Models\Field;
use App\Models\Event;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            $usertype = $user->usertype;
            $name = $user->name;

            $userCount = User::whereIn('usertype', ['user', 'user_field'])->count();
            $fieldCount = Field::count();
            $eventCount = Event::count();
            $problemCount = Problem::count();

            $eventsByMonth = Event::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $eventsByMonth = array_replace(array_fill(1, 12, 0), $eventsByMonth);

            $usersByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $usersByMonth = array_replace(array_fill(1, 12, 0), $usersByMonth);

            $problemsByMonth = Problem::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $problemsByMonth = array_replace(array_fill(1, 12, 0), $problemsByMonth);

            return view('admin.index', compact('usertype', 'name', 'userCount', 'problemCount', 'fieldCount', 'eventCount', 'eventsByMonth', 'usersByMonth', 'problemsByMonth'));
        }
    }


    public function getChartData(Request $request)
    {
        $filter = $request->query('filter', 'month');
        $year = $request->query('year', date('Y'));
        $month = $request->query('month', null);

        switch ($filter) {
            case 'day':
                // Logica para dados diários
                $users = User::selectRaw('DAY(created_at) as period, COUNT(*) as count')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $fields = Field::selectRaw('DAY(created_at) as period, COUNT(*) as count')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $events = Event::selectRaw('DAY(created_at) as period, COUNT(*) as count')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $problems = Problem::selectRaw('DAY(created_at) as period, COUNT(*) as count')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $labels = array_map(fn($day) => "Dia $day", range(1, 31));
                break;

            default:
                $users = User::selectRaw('MONTH(created_at) as period, COUNT(*) as count')
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $fields = Field::selectRaw('MONTH(created_at) as period, COUNT(*) as count')
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $events = Event::selectRaw('MONTH(created_at) as period, COUNT(*) as count')
                    ->whereYear('created_at', $year)
                    ->groupBy('period')
                    ->orderBy('period')
                    ->pluck('count', 'period')
                    ->toArray();

                $problems = Problem::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('count', 'month')
                    ->toArray();

                $labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                break;
        }

        $eventsByPeriod = array_replace(array_fill(1, count($labels), 0), $events);
        $usersByPeriod = array_replace(array_fill(1, count($labels), 0), $users);
        $fieldsByPeriod = array_replace(array_fill(1, count($labels), 0), $fields);
        $problemsByPeriod = array_replace(array_fill(1, count($labels), 0), $problems);

        return response()->json([
            'eventsByPeriod' => array_values($eventsByPeriod),
            'usersByPeriod' => array_values($usersByPeriod),
            'fieldsByPeriod' => array_values($fieldsByPeriod),
            'problemsByPeriod' => array_values($problemsByPeriod), // Retorna os problemas também
            'labels' => $labels,
        ]);
    }

    public function userManagement()
    {
        $users = User::select([
            'id',
            'name',
            'email',
            'usertype',
            'surname',
            'user_name',
            'date_birth',
            'gender',
            'phone',
            'address',
            'profile_picture'
        ])->get();

        $users = User::paginate(10);

        return view('admin.user-management', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($user->usertype === 'owner' && $authUser->usertype !== 'owner') {
            toastr()->timeout(10000)->closeButton()->error('Não tem permissão para alterar as informações do proprietário.');
            return redirect()->back();
        }

        if ($user->usertype === 'admin' && $authUser->usertype !== 'owner') {
            toastr()->timeout(10000)->closeButton()->error('Não tem permissão para alterar as informações de outro administrador.');
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'gender' => 'nullable|in:Masculino,Feminino,Outro',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'usertype' => 'required|in:admin,user,user_field',
        ]);

        if ($authUser->usertype === 'admin' && $validatedData['usertype'] === 'admin') {
            toastr()->timeout(10000)->closeButton()->error('Não tem permissão para promover utilizadores a administrador.');
            return redirect()->back();
        }
    }

    public function updateProfilePicture(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->usertype !== 'owner' && $authUser->id !== $user->id) {
            toastr()->timeout(10000)->closeButton()->error('Não tem permissão para alterar a foto de perfil de outro utilizador.');
            return redirect()->back();
        }

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('Profile_Photo'), $imageName);

            if ($user->profile_picture) {
                $previousImage = public_path('Profile_Photo/' . $user->profile_picture);
                if (file_exists($previousImage)) {
                    unlink($previousImage);
                }
            }

            $user->profile_picture = $imageName;
            $user->save();
        }

        toastr()->timeout(10000)->closeButton()->success('Foto de perfil atualizada com sucesso.');
        return redirect()->back();
    }

    public function ProfilePictureDelete(User $user)
    {
        if ($user->profile_picture) {
            $imagePath = public_path('Profile_Photo/' . $user->profile_picture);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $user->profile_picture = null;
            $user->save();
            toastr()->timeout(10000)->closeButton()->success('Image de perfil do "' . $user->name . '" foi removida com sucesso!');
        }
        return redirect()->route('admin.user-management');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $loginUser = Auth::user();

        if ($loginUser->usertype === 'admin') {
            if ($user->usertype === 'admin') {
                toastr()->timeout(10000)->closeButton()->error('Admin não pode apagar outro Admin');
                return redirect()->back();
            }

            if ($user->usertype === 'owner') {
                toastr()->timeout(10000)->closeButton()->error('Admin não pode apagar o Owner');
                return redirect()->back();
            }

            if ($loginUser->id === $user->id) {
                toastr()->timeout(10000)->closeButton()->error('Você não pode apagar sua própria conta.');
                return redirect()->back();
            }
        }

        if ($loginUser->usertype === 'owner' && $loginUser->id === $user->id) {
            toastr()->timeout(10000)->closeButton()->error('O Owner não pode apagar a sua própria conta.');
            return redirect()->back();
        }
        $user->delete();
        toastr()->timeout(10000)->closeButton()->success($user->name . ' (' . $user->usertype . ') apagado com sucesso!');

        return redirect()->route('admin.user-management');
    }

    public function user_search(Request $request)
    {
        $search = $request->input('search');
        $usertype = $request->input('usertype');

        $query = User::query();

        if ($usertype) {
            $query->where('usertype', $usertype);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')->orWhere('usertype', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10);

        return view('admin.user-management', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function fieldsAdmin()
    {
        $fields = Field::all();
        return view('admin.fields-admin', compact('fields'));
    }

    public function editFields($id)
    {
        $field = Field::findOrFail($id);
        return view('admin.edit-fields-admin', compact('field'));
    }

    public function searchFields(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'asc');

        $fields = Field::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhere('location', 'LIKE', "%$query%")
                    ->orWhere('modality', 'LIKE', "%$query%")
                    ->orWhereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'LIKE', "%$query%")
                            ->orWhere('email', 'LIKE', "%$query%")
                            ->orWhere('contact', 'LIKE', "%$query%");
                    });
            })
            ->orderBy($sort, $direction)
            ->with('user')
            ->get();

        return view('admin.fields-admin', compact('fields'));
    }

    public function updateFields(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'modality' => 'nullable|array',
            'modality.*' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $field->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'location' => $validated['location'],
            'contact' => $validated['contact'] ?? '',
            'price' => $validated['price'],
            'modality' => implode(', ', $validated['modality'] ?? []),
        ]);


        //remove
        if ($request->input('remove_image') == 1) {
            if ($field->image && file_exists(public_path('Fields/' . $field->image))) {
                unlink(public_path('Fields/' . $field->image));
            }
            $field->image = null;
            $field->save();
        }


        toastr()->timeout(10000)->closeButton()->success('Dados do campo "' . $field->name . '" foram alterados com sucesso!');
        return redirect()->route('admin.fields');
    }

    public function destroyFields($id)
    {
        $field = Field::findOrFail($id);

        if ($field->image) {
            $imagePath = public_path('Fields/' . $field->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $field->delete();

        toastr()->timeout(10000)->closeButton()->success('O campo "' . $field->name . '" foi excluído com sucesso!');
        return redirect()->route('admin.fields');
    }

    public function support()
    {
        $problems = Problem::where('is_solved', false)->get();
        return view('admin.support', compact('problems'));
    }

    public function problems_history()
    {
        $problems = Problem::where('is_solved', true)->get();
        return view('admin.problems_history', compact('problems'));
    }

    public function markAsSolved($id)
    {
        $problem = Problem::findOrFail($id);
        $problem->is_solved = true;
        $problem->save();

        return response()->json(['status' => 'success', 'message' => 'Problem marked as solved']);
    }
}
