import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextAreaInput from "@/Components/TextAreaInput";
import TextInput from "@/Components/TextInput";
import { Card, CardContent } from "@/Components/Card";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { 
  BuildingOfficeIcon,
  DocumentTextIcon,
  CheckIcon,
  XMarkIcon
} from "@heroicons/react/24/outline";

export default function Create({ auth }) {
  const { data, setData, post, errors, reset, processing } = useForm({
    name: "",
    description: "",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    post(route("department.store"));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Create New Department</h2>
            <p className="text-sm text-gray-600 mt-1">
              Add a new department to your organization
            </p>
          </div>
          <Link
            href={route("departments.index")}
            className="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200"
          >
            <XMarkIcon className="w-4 h-4 mr-2" />
            Cancel
          </Link>
        </div>
      }
    >
      <Head title="Create Department" />

      <div className="py-8">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <Card className="overflow-hidden">
            <form onSubmit={onSubmit} className="divide-y divide-gray-200">
              {/* Department Icon Section */}
              <CardContent className="p-6">
                <div className="space-y-6">
                  <div className="text-center">
                    <div className="mx-auto w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                      <BuildingOfficeIcon className="w-12 h-12 text-emerald-600" />
                    </div>
                    <h3 className="text-lg font-medium text-gray-900">Department Information</h3>
                    <p className="text-sm text-gray-500 mt-1">
                      Provide basic information about the new department
                    </p>
                  </div>
                </div>
              </CardContent>

              {/* Department Details Section */}
              <CardContent className="p-6">
                <div className="space-y-6">
                  <div className="grid grid-cols-1 gap-6">
                    <div>
                      <InputLabel 
                        htmlFor="department_name" 
                        value="Department Name" 
                        className="text-sm font-medium text-gray-700" 
                      />
                      <div className="mt-1 relative">
                        <TextInput
                          id="department_name"
                          type="text"
                          name="name"
                          value={data.name}
                          className="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          placeholder="e.g., Human Resources, Engineering, Marketing"
                          isFocused={true}
                          onChange={(e) => setData("name", e.target.value)}
                        />
                      </div>
                      {errors.name && (
                        <InputError message={errors.name} className="mt-2" />
                      )}
                    </div>

                    <div>
                      <InputLabel 
                        htmlFor="department_description" 
                        value="Department Description" 
                        className="text-sm font-medium text-gray-700" 
                      />
                      <div className="mt-1 relative">
                        <DocumentTextIcon className="absolute left-3 top-3 text-gray-400 w-5 h-5" />
                        <TextAreaInput
                          id="department_description"
                          name="description"
                          value={data.description}
                          className="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          rows={4}
                          placeholder="Describe the department's role, responsibilities, and objectives..."
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
                    href={route("departments.index")}
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
                        Create Department
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
