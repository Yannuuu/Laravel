<x-layouts.app :tittle="__('Create new Post')">
    <form action="" method="POST">
        @csrf
        <flux:input
            label="Tittle"
            name="tittle"
            type="text"
            class="mb-3"
            placeholder="Enter post tittle" required />

        <flux:input
            label="Slug"
            name="slug"
            type="text"
            class="mb-3"
            placeholder="Enter post tittle" required />

        <flux:textarea
            label="Content"
            name="content"
            type="textarea"
            clas="mb-3"
            placeholder="Enter post tittle" required />

        <flux:input
            label="Image"
            name="image"
            class="mb-3"
            type="file" accept="image/*" required />
        
        <flux:button type="submit" variant="primary">
            Save
        </flux:button>
    </form>
</x-layouts.app>