import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { Card, CardContent } from "@/Components/Card";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { 
  ClipboardDocumentListIcon,
  DocumentTextIcon,
  ArrowLeftIcon,
  PencilIcon
} from "@heroicons/react/24/outline";

export default function Edit({ auth, evaluation: evaluationData }) {
  // Destructure the nested data
  const evaluation = evaluationData.data || {};

  const { data, setData, put, errors, processing } = useForm({
    title: evaluation.title || "",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    put(route("evaluations.update", evaluation.id));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div className="flex items-center space-x-4">
            <Link
              href={route("evaluations.show", evaluation.id)}
              className="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all"
            >
              <ArrowLeftIcon className="w-5 h-5" />
            </Link>
            <div>
              <h2 className="text-2xl font-bold text-gray-900">Edit Evaluation</h2>
              <p className="text-sm text-gray-600 mt-1">
                Update the evaluation form details
              </p>
            </div>
          </div>
          <div className="flex items-center space-x-2">
            <div className="flex items-center space-x-2 text-sm text-gray-500">
              <PencilIcon className="w-4 h-4" />
              <span>Editing #{evaluation.id}</span>
            </div>
          </div>
        </div>
      }
    >
      <Head title={`Edit Evaluation: ${evaluation.title}`} />

      <div className="py-8">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <form onSubmit={onSubmit} className="space-y-6">
            {/* Evaluation Information Section */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <div className="flex items-center space-x-3">
                    <div className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                      <DocumentTextIcon className="w-5 h-5 text-blue-600" />
                    </div>
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">Evaluation Information</h3>
                      <p className="text-sm text-gray-600">Update the evaluation form details</p>
                    </div>
                  </div>
                </div>

                {/* Current Evaluation Info */}
                <div className="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                  <div className="flex items-center space-x-3">
                    <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                      <ClipboardDocumentListIcon className="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                      <h4 className="text-lg font-medium text-gray-900">Current Evaluation</h4>
                      <p className="text-sm text-gray-600">#{evaluation.id} - {evaluation.title}</p>
                    </div>
                  </div>
                </div>

                {/* Khmer Header */}
                <div className="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                  <h4 className="text-lg font-medium text-blue-900 mb-2">
                    ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
                  </h4>
                  <p className="text-sm text-blue-700">
                    Section 2: Assessment Points, Practical Work Implementation, Additional Comments and Department Head Responses
                  </p>
                </div>

                <div className="grid grid-cols-1 gap-6">
                  {/* Evaluation Title */}
                  <div>
                    <InputLabel 
                      htmlFor="evaluation_title" 
                      value="Evaluation Title / កម្រងសំណួរទី" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <TextInput
                        id="evaluation_title"
                        type="text"
                        name="title"
                        value={data.title}
                        className="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter evaluation title (e.g., Monthly Performance Review, Annual Assessment)"
                        onChange={(e) => setData("title", e.target.value)}
                        required
                      />
                    </div>
                    <InputError message={errors.title} className="mt-2" />
                    <p className="mt-2 text-xs text-gray-500">
                      Choose a descriptive title that clearly identifies the purpose and scope of this evaluation.
                    </p>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Evaluation Metadata */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <h3 className="text-lg font-semibold text-gray-900">Evaluation Metadata</h3>
                  <p className="text-sm text-gray-600">Information about this evaluation's history</p>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label className="text-sm font-medium text-gray-700 block mb-2">
                      Created By
                    </label>
                    <p className="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                      {evaluation.createdBy?.name || 'Unknown User'}
                    </p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 block mb-2">
                      Last Updated By
                    </label>
                    <p className="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                      {evaluation.updatedBy?.name || 'Unknown User'}
                    </p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 block mb-2">
                      Created Date
                    </label>
                    <p className="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                      {evaluation.created_at}
                    </p>
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 block mb-2">
                      Last Updated
                    </label>
                    <p className="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                      {evaluation.updated_at}
                    </p>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Form Actions */}
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
              <div className="text-sm text-gray-500">
                <span className="font-medium">Note:</span> Changes will be saved immediately upon submission.
              </div>
              
              <div className="flex items-center space-x-3">
                <SecondaryButton>
                  <Link href={route("evaluations.show", evaluation.id)}>
                    Cancel
                  </Link>
                </SecondaryButton>
                
                <PrimaryButton 
                  type="submit" 
                  disabled={processing}
                  className="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500"
                >
                  {processing ? (
                    <div className="flex items-center space-x-2">
                      <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                      <span>Updating...</span>
                    </div>
                  ) : (
                    <div className="flex items-center space-x-2">
                      <PencilIcon className="w-4 h-4" />
                      <span>Update Evaluation</span>
                    </div>
                  )}
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
