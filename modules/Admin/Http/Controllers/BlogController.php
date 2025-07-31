<?php

namespace Modules\Admin\Http\Controllers;

use App\Containers\Blog\Actions\GetBlogsAction;
use App\Containers\Blog\Actions\GetBlogByIdAction;
use App\Containers\Blog\Actions\CreateBlogAction;
use App\Containers\Blog\Actions\UpdateBlogAction;
use App\Containers\Blog\Actions\DeleteBlogAction;
use App\Containers\Blog\Data\DTOs\CreateBlogDTO;
use App\Containers\Blog\Data\DTOs\UpdateBlogDTO;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use InvalidArgumentException;

/**
 * Blog Management Controller for Admin Module
 * 
 * Handles all blog management operations including CRUD operations,
 * filtering, and blog-specific queries for the admin interface.
 */
class BlogController extends Controller
{
    /**
     * Constructor with dependency injection
     * 
     * @param GetBlogsAction $getBlogsAction
     * @param GetBlogByIdAction $getBlogByIdAction
     * @param CreateBlogAction $createBlogAction
     * @param UpdateBlogAction $updateBlogAction
     * @param DeleteBlogAction $deleteBlogAction
     */
    public function __construct(
        private readonly GetBlogsAction $getBlogsAction,
        private readonly GetBlogByIdAction $getBlogByIdAction,
        private readonly CreateBlogAction $createBlogAction,
        private readonly UpdateBlogAction $updateBlogAction,
        private readonly DeleteBlogAction $deleteBlogAction
    ) {}

    /**
     * Display a listing of the blogs.
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $filters = $request->all();
            $filters['paginate'] = true; // Always use pagination for admin
            
            $blogs = $this->getBlogsAction->execute($filters);
            return view('admin::blogs.index', compact('blogs'));
        } catch (\Exception $e) {
            return view('admin::blogs.index')->with('error', 'Failed to retrieve blogs: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new blog.
     * 
     * @return View
     */
    public function create(): View
    {
        return view('admin::blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate(CreateBlogDTO::rules());
            $dto = CreateBlogDTO::fromRequest($request);
            $blog = $this->createBlogAction->execute($dto);
            return redirect()->route('admin.blogs.show', $blog->id)
                ->with('success', 'Blog created successfully');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create blog: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified blog.
     * 
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        try {
            $blog = $this->getBlogByIdAction->execute($id);
            if (!$blog) {
                return view('admin::blogs.show')->with('error', 'Blog not found');
            }
            return view('admin::blogs.show', compact('blog'));
        } catch (\Exception $e) {
            return view('admin::blogs.show')->with('error', 'Failed to retrieve blog: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified blog.
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        try {
            $blog = $this->getBlogByIdAction->execute($id);
            if (!$blog) {
                return view('admin::blogs.edit')->with('error', 'Blog not found');
            }
            return view('admin::blogs.edit', compact('blog'));
        } catch (\Exception $e) {
            return view('admin::blogs.edit')->with('error', 'Failed to retrieve blog: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified blog in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $request->validate(UpdateBlogDTO::rules($id));
            $dto = UpdateBlogDTO::fromRequest($request);
            $blog = $this->updateBlogAction->execute($id, $dto);
            if (!$blog) {
                return back()->withInput()->withErrors(['error' => 'Blog not found']);
            }
            return redirect()->route('admin.blogs.show', $blog->id)
                ->with('success', 'Blog updated successfully');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to update blog: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified blog from storage.
     * 
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->deleteBlogAction->execute($id);
            if (!$deleted) {
                return back()->withErrors(['error' => 'Blog not found']);
            }
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete blog: ' . $e->getMessage()]);
        }
    }

    /**
     * Publish the specified blog.
     * 
     * @param int $id
     * @return RedirectResponse
     */
    public function publish(int $id): RedirectResponse
    {
        try {
            $blog = $this->updateBlogAction->execute($id, new UpdateBlogDTO(status: 'published'));
            if (!$blog) {
                return back()->withErrors(['error' => 'Blog not found']);
            }
            return redirect()->route('admin.blogs.index')->with('success', 'Blog published successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to publish blog: ' . $e->getMessage()]);
        }
    }

    /**
     * Archive the specified blog.
     * 
     * @param int $id
     * @return RedirectResponse
     */
    public function archive(int $id): RedirectResponse
    {
        try {
            $blog = $this->updateBlogAction->execute($id, new UpdateBlogDTO(status: 'archived'));
            if (!$blog) {
                return back()->withErrors(['error' => 'Blog not found']);
            }
            return redirect()->route('admin.blogs.index')->with('success', 'Blog archived successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to archive blog: ' . $e->getMessage()]);
        }
    }
} 