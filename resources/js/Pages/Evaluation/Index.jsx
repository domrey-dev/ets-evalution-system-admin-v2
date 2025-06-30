import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import TextInput from "@/Components/TextInput";
import PrimaryButton from "@/Components/PrimaryButton";
import { useState } from "react";
import { 
  MagnifyingGlassIcon,
  PlusIcon,
  EyeIcon,
  PencilIcon,
  TrashIcon,
  UserIcon,
  ChartBarIcon
} from "@heroicons/react/24/outline";

export default function Index({ auth, success, evaluations, queryParams = null }) {
  const [filters, setFilters] = useState({
    search: queryParams?.search || ""
  });

  const clearFilters = () => {
    const clearedFilters = {
      search: ''
    };
    setFilters(clearedFilters);
    
    // Automatically apply cleared filters
    router.get(route("evaluations.index"), {}, {
      preserveState: true,
      replace: true,
    });
  };

  const applyFilters = () => {
    // Remove empty filters
    const filterData = {};
    Object.keys(filters).forEach(key => {
      if (filters[key]) {
        filterData[key] = filters[key];
      }
    });

    router.get(route("evaluations.index"), filterData, {
      preserveState: true,
      replace: true,
    });
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      applyFilters();
    }
  };

  const deleteEvaluation = (evaluation) => {
    if (!window.confirm(`Are you sure you want to delete the "${evaluation.title}" evaluation?`)) {
      return;
    }
    router.delete(route("evaluations.destroy", evaluation.id));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Evaluations</h2>
            <p className="text-sm text-gray-600 mt-1">
              ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
            </p>
          </div>
          <Link
            href={route("evaluations.create")}
            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow-sm transition-all duration-200"
          >
            <PlusIcon className="w-4 h-4 mr-2" />
            New Evaluation
          </Link>
        </div>
      }
    >
      <Head title="Evaluations" />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Success Message */}
          {success && (
            <div className="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
              {success}
            </div>
          )}

          {/* Search and Filters */}
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                {/* <h3 className="text-lg font-semibold text-gray-900 mb-4">Filter Evaluations</h3> */}
                <div className="flex flex-col lg:flex-row lg:items-end gap-4">
                  <div className="flex-1">
                    <div className="grid grid-cols-1 gap-4">
                      <div className="min-w-0">
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Evaluation Name
                        </label>
                        <TextInput
                          className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                          defaultValue={queryParams?.search}
                          placeholder="Search evaluations..."
                          value={filters.search}
                          onChange={(e) => setFilters({...filters, search: e.target.value})}
                          onKeyPress={handleKeyPress}
                        />
                      </div>
                    </div>
                  </div>
                  
                  <div className="hidden lg:block w-px h-16 bg-gray-300 mx-4"></div>
                  
                  <div className="flex flex-row gap-3 lg:flex-shrink-0">
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={clearFilters}
                    >
                      Clear
                    </PrimaryButton>
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={applyFilters}
                    >
                      Apply
                    </PrimaryButton>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Content */}
          {evaluations.data && evaluations.data.length > 0 ? (
            /* Table View */
            <Card>
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                        ID
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Evaluation Title
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Responses
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Created By
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Created Date
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Updated Date
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {evaluations.data.map((evaluation) => (
                      <tr key={evaluation.id} className="hover:bg-gray-50">
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                          {evaluation.id}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4">
                          <div className="text-xs sm:text-sm font-medium text-gray-900 truncate">
                            {evaluation.title}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                          <div className="flex items-center">
                            <ChartBarIcon className="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mr-1 sm:mr-2" />
                            <span className="text-xs sm:text-sm text-gray-900"> {evaluation.total_responses || 0}</span>
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-24 sm:max-w-32">
                            {evaluation.createdBy?.name || 'Unknown'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          {evaluation.created_at}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          {evaluation.updated_at}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                          <div className="flex items-center justify-end space-x-1 sm:space-x-2">
                            <Link
                              href={route("evaluations.show", evaluation.id)}
                              className="text-blue-600 hover:text-blue-900 transition-colors"
                              title="View"
                            >
                              <EyeIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </Link>
                            <Link
                              href={route("evaluations.edit", evaluation.id)}
                              className="text-emerald-600 hover:text-emerald-900 transition-colors"
                              title="Edit"
                            >
                              <PencilIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </Link>
                            <button
                              onClick={() => deleteEvaluation(evaluation)}
                              className="text-red-600 hover:text-red-900 transition-colors"
                              title="Delete"
                            >
                              <TrashIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Card>
          ) : (
            /* Empty State */
            <Card className="text-center py-12">
              <CardContent>
                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <PlusIcon className="w-12 h-12 text-gray-400" />
                </div>
                <h3 className="text-lg font-medium text-gray-900 mb-2">No evaluations found</h3>
                <p className="text-gray-500 mb-6">
                  {filters.search 
                    ? `No evaluations match "${filters.search}". Try adjusting your search.`
                    : "Get started by creating your first evaluation form."
                  }
                </p>
                {!filters.search && (
                  <Link
                    href={route("evaluations.create")}
                    className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all"
                  >
                    <PlusIcon className="w-4 h-4 mr-2" />
                    Create Evaluation
                  </Link>
                )}
              </CardContent>
            </Card>
          )}
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
