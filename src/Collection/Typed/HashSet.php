/* Collection\Typed\HashSet */
namespace {{ namespace }} {
	use Collection\HashSet as BaseHashSet;
	use Collection\Assert as Assert;
	use Collection\Shared\Typed\BasicCollectionTrait;

	class {{ className }} extends BaseHashSet
	{
		use BasicCollectionTrait;

		protected $typeName = '{{ typeName }}';
	}
}