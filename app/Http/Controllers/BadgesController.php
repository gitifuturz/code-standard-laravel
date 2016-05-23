<?php

namespace Project\Http\Controllers;

use Project\Models\Badge;
use Illuminate\Http\Request;

use Project\Http\Requests;
use Illuminate\Support\Facades\View;

class BadgesController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        $this->breadcrumb = array(
            'Home'=>'/',
            'Badges'=>'/badges'
        );


        View::share('breadcrumb',$this->breadcrumb);

        $this->activeMenus = ['badges','badges.manage'];
        View::share('active',$this->activeMenus);
        return view('page_badges.index')->with('badges',$badges);
    }

    public function add()
    {
        $this->breadcrumb = array(
            'Home'=>'/',
            'Badges'=>'/badges',
            'Add Badges'=>'/badges/add'
        );

        $this->activeMenus = ['badges','badges.add'];
        View::share('active',$this->activeMenus);

        View::share('breadcrumb',$this->breadcrumb);
        return view('page_badges.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|min:3',
        ]);

        Badge::create($request->all());
        return redirect('badges/add')->with('success','Badge added successfully');
    }

    public function edit($badgeId)
    {
        $badge = Badge::find($badgeId);
        $this->breadcrumb = array(
            'Home'=>'/',
            'Badges'=>'/badges',
            'Edit Badges'=>"/badges/$badgeId/edit"
        );

        View::share('breadcrumb',$this->breadcrumb);

        $this->activeMenus = ['badges','badges.edit'];
        View::share('active',$this->activeMenus);

        return view('page_badges.edit')
            ->with('badge',$badge);
    }

    public function update(Request $request, $badgeId)
    {
        $this->validate($request, [
            'name' => 'required|max:255|min:3'
        ]);

        $badge = Badge::findOrFail($badgeId);
        $badge->fill($request->all())->save();

        return redirect()->back()->withSuccess('Badge updated successfully');
    }

    public function destroy($badgeId)
    {
        $badge =  Badge::findOrFail($badgeId);
        $badge->delete();

        return redirect()->back()->withSuccess('Badge deleted successfully');
    }
}
