import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";
import TextInput from "@/Components/TextInput";
import { Card, CardContent } from "@/Components/Card";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { 
  PhotoIcon, 
  CalendarIcon, 
  DocumentTextIcon,
  CheckIcon,
  XMarkIcon
} from "@heroicons/react/24/outline";

export default function Create({ auth }) {
  const { data, setData, post, errors, reset, processing } = useForm({
    image: "",
    name: "",
    status: "",
    description: "",
    due_date: "",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    post(route("project.store"));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Create New Project</h2>
            <p className="text-sm text-gray-600 mt-1">
              Add a new project to your portfolio
            </p>
          </div>
          {/* <Link
            href={route("project.index")}
            className="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200"
          >
            <XMarkIcon className="w-4 h-4 mr-2" />
            Cancel
          </Link> */}
        </div>
      }
    >
      <Head title="Create Project" />

      <div className="py-8">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <Card className="overflow-hidden">
            <form onSubmit={onSubmit} className="divide-y divide-gray-200">
              {/* Project Image Section
              <CardContent className="p-6">
                <div className="space-y-6">
                  <div>
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Project Image</h3>
                    <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                      <div className="space-y-1 text-center">
                        <PhotoIcon className="mx-auto h-12 w-12 text-gray-400" />
                        <div className="flex text-sm text-gray-600">
                          <label
                            htmlFor="project_image_path"
                            className="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500"
                          >
                            <span>Upload a file</span>
                            <input
                              id="project_image_path"
                              name="image"
                              type="file"
                              className="sr-only"
                              accept="image/*"
                              onChange={(e) => setData("image", e.target.files[0])}
                            />
                          </label>
                          <p className="pl-1">or drag and drop</p>
                        </div>
                        <p className="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                      </div>
                    </div>
                    {errors.image && (
                      <InputError message={errors.image} className="mt-2" />
                    )}
                  </div>
                </div>
              </CardContent> */}

              {/* Project Details Section */}
              <CardContent className="p-6">
                <div className="space-y-6">
                  <div>
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Project Details</h3>
                  </div>
                  
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="md:col-span-2">
                      <InputLabel htmlFor="project_name" value="Project Name" className="text-sm font-medium text-gray-700" />
                      <div className="mt-1 relative">
                        <TextInput
                          id="project_name"
                          type="text"
                          name="name"
                          value={data.name}
                          className="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          placeholder="Enter project name"
                          isFocused={true}
                          onChange={(e) => setData("name", e.target.value)}
                        />
                      </div>
                      {errors.name && (
                        <InputError message={errors.name} className="mt-2" />
                      )}
                    </div>

                    <div>
                      <InputLabel htmlFor="project_due_date" value="Due Date" className="text-sm font-medium text-gray-700" />
                      <div className="mt-1 relative">
                        <CalendarIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                        <TextInput
                          id="project_due_date"
                          type="date"
                          name="due_date"
                          value={data.due_date}
                          className="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          onChange={(e) => setData("due_date", e.target.value)}
                        />
                      </div>
                      {errors.due_date && (
                        <InputError message={errors.due_date} className="mt-2" />
                      )}
                    </div>

                    <div>
                      <InputLabel htmlFor="project_status" value="Project Status" className="text-sm font-medium text-gray-700" />
                      <div className="mt-1">
                        <SelectInput
                          name="status"
                          id="project_status"
                          className="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          value={data.status}
                          onChange={(e) => setData("status", e.target.value)}
                        >
                          <option value="">Select Status</option>
                          <option value="pending">Pending</option>
                          <option value="in_progress">In Progress</option>
                          <option value="completed">Completed</option>
                        </SelectInput>
                      </div>
                      {errors.status && (
                        <InputError message={errors.status} className="mt-2" />
                      )}
                    </div>

                    <div className="md:col-span-2">
                      <InputLabel htmlFor="project_description" value="Project Description" className="text-sm font-medium text-gray-700" />
                      <div className="mt-1 relative">
                        <DocumentTextIcon className="absolute left-3 top-3 text-gray-400 w-5 h-5" />
                        <TextAreaInput
                          id="project_description"
                          name="description"
                          value={data.description}
                          className="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          rows={4}
                          placeholder="Describe your project goals, requirements, and key details..."
                          onChange={(e) => setData("description", e.target.value)}
                        />
                      </div>
                      {errors.description && (
                        <InputError message={errors.description} className="mt-2" />
                      )}
                    </div>
                  </div>
                </div>
              </CardContent>

              {/* Form Actions */}
              <CardContent className="px-6 py-4 bg-gray-50">
                <div className="flex items-center justify-end space-x-3">
                  <Link
                    href={route("project.index")}
                    className="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all"
                  >
                    <XMarkIcon className="w-4 h-4 mr-2" />
                    Cancel
                  </Link>
                  <button
                    type="submit"
                    disabled={processing}
                    className="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                  >
                    {processing ? (
                      <>
                        <svg className="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating...
                      </>
                    ) : (
                      <>
                        <CheckIcon className="w-4 h-4 mr-2" />
                        Create Project
                      </>
                    )}
                  </button>
                </div>
              </CardContent>
            </form>
          </Card>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
